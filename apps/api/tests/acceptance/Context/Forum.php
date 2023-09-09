<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Behat\Gherkin\Node\TableNode;
use Domain\Model\Station;
use Domain\Model\User;
use Infra\Assert\Assert;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class Forum extends Context
{
    private ?Station $station = null;
    private ?User $user = null;

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->station = null;
        $this->user = null;

        $this->persistence->clear();
    }

    /**
     * @Given I am a visitor
     */
    public function iAmAVisitor(): void
    {
    }

    /**
     * @Given I am a user
     */
    public function iAmAUser(): void
    {
        $emailAddress = $this->faker->email();

        /** @var User */
        $user = $this->faker->user($emailAddress);

        $this->persistence->users->add($user);
        $this->http->auth($emailAddress);

        $this->user = $user;
    }

    /**
     * @Given I am an admin
     */
    public function iAmAnAdmin(): void
    {
        $emailAddress = $this->faker->email();

        /** @var User */
        $user = $this->faker->admin($emailAddress);

        $this->persistence->users->add($user);
        $this->http->auth($emailAddress);

        $this->user = $user;
    }

    /**
     * @Given There is the station ":name"
     */
    public function thereIsTheStation(string $name): void
    {
        $this->station = new Station(
            name: $name,
            description: null
        );

        $this->persistence->stations->add($this->station);
    }

    /**
     * @Given I am not member of the station
     */
    public function iAmNotMemberOfTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }
    }

    /**
     * @Given There is multiple forums in the station
     */
    public function thereIsMultipleForumsInTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        foreach (range(start: 0, end: 4) as $i) {
            $forum = new \Domain\Model\Forum\Forum(
                name: $this->faker->company(),
                station: $this->station
            );

            $this->persistence->manager->persist($forum);
        }

        $this->persistence->manager->flush();
    }

    /**
     * @Given I am member of the station
     */
    public function iAmMemberOfTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        if (null === $this->user) {
            throw new RuntimeException('No user authenticated during this scenario.');
        }

        $this->user->joinGroup($this->station);
        $this->persistence->manager->flush();
    }

    /**
     * @When I create a new forum for the station with
     */
    public function iCreateAForumForTheStation(TableNode $table): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $data = current($table->getColumnsHash());
        $name = $data['name'];
        $id = (string) $this->station->getIdentifier();

        $this->http->post(
            uri: "/station/{$id}/forums",
            content: ['name' => $name]
        );
    }

    /**
     * @When I list all forums of the station
     */
    public function iListAllForumsOfTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();

        $this->http->get("/station/{$id}/forums");
    }

    /**
     * @When I create a forum ":name" for non existing station
     */
    public function iCreateAForumForANonExistingStation(string $name): void
    {
        $this->http->post(
            uri: '/station/6baabfbe-8da5-4f7d-a113-484fda5bca06/forums',
            content: [
                'name' => $name
            ]
        );
    }

    /**
     * @Then I should be notified that the forum is created
     */
    public function iShouldBeNotifiedThatTheForumIsCreated(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No forum created during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_CREATED);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'forum-item'
        );
    }

    /**
     * @Then I should see the list of all forums in this station
     */
    public function iShouldSeeTheListOfAllForumsOfThisStation(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_OK);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'forums'
        );
    }

    /**
     * @Then I should be notified that I'm not authorized for operation ":operation"
     */
    public function iShouldBeNotifiedThatImNotAuthorizedForOperation(string $operation): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        $content = $this->http->getLastJson();

        Assert::that($response->getStatusCode())->eq(Response::HTTP_FORBIDDEN);
        Assert::that($content)->keyExists('error');
        Assert::that(
            preg_match(sprintf('/Operation \'%s\' is not permitted./', $operation),
            $content['error']['message'])
        )->eq(1);
    }

    /**
     * @Then I should be notified that the station does not exists
     */
    public function iShouldBeNotifiedThatTheStationDoesNotExists(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_NOT_FOUND);
    }
}
