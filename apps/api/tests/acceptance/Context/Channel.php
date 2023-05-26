<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Domain\Model\Channel as ModelChannel;
use Domain\Model\Station;
use Domain\Model\User;
use Infra\Assert\Assert;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class Channel extends Context
{
    private ?Station $station = null;
    private ?ModelChannel $channel = null;
    private ?User $user = null;

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->station = null;
        $this->channel = null;
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
     * @Given There is a ":name" channel in the station
     */
    public function thereIsAChannelInTheStation(string $name): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $this->channel = new ModelChannel(
            name: $name,
            description: $this->faker->sentence(),
            station: $this->station
        );

        $this->persistence->channels->add($this->channel);
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
     * @Given There is multiple members in the channel
     */
    public function thereIsMultipleMembersInTheChannel(): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        foreach (range(start: 0, end: 4, step: 3) as $iteration) {
            /** @var User */
            $member = $this->faker->user($this->faker->unique()->email());

            $member->joinGroup($this->channel->getStation());
            $member->joinGroup($this->channel);
            $this->persistence->manager->persist($member);
        }

        $this->persistence->manager->flush();
    }

    /**
     * @Given I am member of the channel
     */
    public function iAmMemberOfTheChannel(): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        if (null === $this->user) {
            throw new RuntimeException('No user authenticated during this scenario.');
        }

        $this->user->joinGroup($this->channel);
        $this->persistence->manager->flush();
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
     * @Given I am not member of the channel
     */
    public function iAmNotMemberOfTheChannel(): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }
    }

    /**
     * @When I create a channel ":name" for the station
     */
    public function iCreateAChannelForTheStation(string $name): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();

        $this->http->post(
            uri: "/station/{$id}/channels",
            content: [
                'name' => $name,
                'description' => $this->faker->sentence(),
            ]
        );
    }

    /**
     * @When I create a channel ":name" for non existing station
     */
    public function iCreateAChannelForNonExistingStation(string $name): void
    {
        $this->http->post(
            uri: '/station/6baabfbe-8da5-4f7d-a113-484fda5bca06/channels',
            content: [
                'name' => $name,
                'description' => $this->faker->sentence()
            ]
        );
    }

    /**
     * @When I delete the channel
     */
    public function iDeleteTheChannel(): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        $id = (string) $this->channel->getIdentifier();

        $this->http->delete("/channel/{$id}");
    }

    /**
     * @When I delete an non existing channel
     */
    public function iDeleteANonExistingChannel(): void
    {
        $this->http->delete(uri: '/channel/6baabfbe-8da5-4f7d-a113-484fda5bca06');
    }

    /**
     * @When I join the channel
     */
    public function whenIJoinTheChannel(): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        $id = (string) $this->channel->getIdentifier();

        $this->http->post("/channel/{$id}/join");
    }

    /**
     * @When I list all channels of the station
     */
    public function iListChannelsOfTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();

        $this->http->get("/station/{$id}/channels");
    }

    /**
     * @When I list all members of the channel
     */
    public function iListAllMembersOfTheChannel(): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        $id = (string) $this->channel->getIdentifier();

        $this->http->get("/channel/{$id}/users");
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
     * @Then I should be notified that the channel is created
     */
    public function iShouldBeNotifiedThatTheChannelIsCreated(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_CREATED);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'channel-item'
        );
    }

    /**
     * @Then I should be notified that the channel is deleted
     */
    public function iShouldBeNotifiedThatTheChannelIsDeleted(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_NO_CONTENT);
    }

    /**
     * @Then I should be notified that the station does not exists
     * @Then I should be notified that the channel does not exists
     */
    public function iShouldBeNotifiedThatDoesNotExists(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_NOT_FOUND);
    }

    /**
     * @Then I should be notified that I joined the channel
     */
    public function iShouldBeNotifiedThatIJoinedTheChannel(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_OK);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'channel-item'
        );
    }

    /**
     * @Then I should see the list of the members
     */
    public function iShouldSeeTheListOfTheMembers(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_OK);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'users'
        );
    }

    /**
     * @Then I should see the list of all channels in this station
     */
    public function iShouldSeeTheListOfAllChannelsInThisStation(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_OK);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'channels'
        );
    }
}
