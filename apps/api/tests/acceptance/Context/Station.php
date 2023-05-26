<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Behat\Gherkin\Node\TableNode;
use Domain\Model\Invitation;
use Domain\Model\Station as ModelStation;
use Domain\Model\User;
use Infra\Assert\Assert;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class Station extends Context
{
    private ?string $stationName = null;
    private ?string $stationDescription = null;
    private ?User $user = null;
    private ?ModelStation $station = null;
    private ?Invitation $invitation = null;

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->stationName = null;
        $this->stationDescription = null;
        $this->user = null;
        $this->station = null;
        $this->invitation = null;

        $this->persistence->clear();
    }

    /**
     * @Given There is an existing ":name" station
     */
    public function thereIsAnExistingStation(string $name): void
    {
        $this->station = new ModelStation(
            name: $name,
            description: null
        );

        $this->persistence->stations->add($this->station);
    }

    /**
     * @Given There is multiple members in the station
     */
    public function thereIsMultipleMembersInTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        foreach (range(start: 0, end: 4, step: 3) as $iteration) {
            /** @var User */
            $member = $this->faker->user($this->faker->unique()->email());

            $member->joinGroup($this->station);
            $this->persistence->manager->persist($member);
        }

        $this->persistence->manager->flush();
    }

    /**
     * @Given There is an invitation to join the station
     */
    public function thereIsAnInvitationToJoin(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $this->invitation = new Invitation($this->station);
        $this->persistence->invitations->add($this->invitation);
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
     * @Given I am not member of the station
     */
    public function iAmNotMemberOfTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }
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
     * @When I create a new station with
     */
    public function iCreateANewStation(TableNode $table): void
    {
        $data = current($table->getColumnsHash());
        $this->stationName = $data['name'];
        $this->stationDescription = $data['description'];

        $this->http->post('/stations', [
            'name' => $this->stationName,
            'description' => $this->stationDescription
        ]);
    }

    /**
     * @When I delete the station
     */
    public function iDeleteTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();

        $this->http->delete("/station/{$id}");
    }

    /**
     * @When I delete an non existing station
     */
    public function iDeleteAnNonExistingStation(): void
    {
        $this->http->delete('/station/0b3e6771-3460-4359-9c5a-4bdf15cefcbf');
    }

    /**
     * @When I create a new invitation for a station that does not exists
     */
    public function iCreateAnInvitationForAStationThatDoesNotExists(): void
    {
        $this->http->post('/station/0b3e6771-3460-4359-9c5a-4bdf15cefcbf/invite');
    }

    /**
     * @When I join a non existing station
     */
    public function iJoinAnNonExistingStation(): void
    {
        $this->http->post('/station/0b3e6771-3460-4359-9c5a-4bdf15cefcbf/join', [ 'token' => 'azertyuip' ]);
    }

    /**
     * @When I create a new invitation for the station
     */
    public function iCreateANewInvitation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();

        $this->http->post("/station/{$id}/invite");
    }

    /**
     * @When I join the station using the invitation token
     */
    public function iJoinTheStationUsingTheInvitation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        if (null === $this->invitation) {
            throw new RuntimeException('No invitation created during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();
        $token = (string) $this->invitation->getToken();

        $this->http->post("/station/{$id}/join", [ 'token' => $token ]);
    }

    /**
     * @When I join the station using not existing invitation token
     * @When I join the station using wrong invitation token
     */
    public function iJoinTheStationUsingNotExistingInvitation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();
        $token = (string) (new Invitation($this->station))->getToken();

        $this->http->post("/station/{$id}/join", [ 'token' => $token ]);
    }

    /**
     * @When I list members of the station
     */
    public function iListMembersOfTheStation(): void
    {
        if (null === $this->station) {
            throw new RuntimeException('No station created during this scenario.');
        }

        if (null === $this->user) {
            throw new RuntimeException('No user authenticated during this scenario.');
        }

        $id = (string) $this->station->getIdentifier();

        $this->http->get("/station/{$id}/users");
    }

    /**
     * @Then I should be notified that the station is created
     */
    public function iShouldBeNotifiedThatTheStationIsCreated(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No station created during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_CREATED);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'station-item'
        );
    }

    /**
     * @Then I should be notified that the station is deleted
     */
    public function iShouldBeNotifiedThatTheStationIsDeleted(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No station deleted during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_NO_CONTENT);
    }

    /**
     * @Then I should be notified that the invitation is created
     */
    public function iShouldBeNotifiedThatTheInvitationIsCreated(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No invitation created during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_CREATED);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'invitation-item'
        );
    }

    /**
     * @Then I should be notified that I joined the station
     */
    public function iShouldBeNotifiedThatIJoinedTheStation(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No invitation created during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_OK);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'station-item'
        );
    }

    /**
     * @Then I should be notified that the invitation is wrong
     * @Then I should be notified that I'm already a member
     */
    public function iShouldBeNotifiedThatTheRequestIsNotValid(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Then I should be notified that I'm not authorized
     */
    public function iShouldBeNotifiedThatImNotAuthorized(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_UNAUTHORIZED);
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
     * @Then I should be notified that the invitation does not exists
     */
    public function iShouldBeNotifiedThatTheStationDoesNotExists(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_NOT_FOUND);
    }

    /**
     * @Then I should see the list of members in the station
     */
    public function iShouldSeeTheListOfMembersInTheStation(): void
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
}
