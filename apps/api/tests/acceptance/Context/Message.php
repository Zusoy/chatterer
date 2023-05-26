<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Domain\Model\Channel;
use Domain\Model\Message as ModelMessage;
use Domain\Model\Station;
use Domain\Model\User;
use Infra\Assert\Assert;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class Message extends Context
{
    private ?User $user = null;
    private ?Station $station = null;
    private ?Channel $channel = null;
    private ?ModelMessage $message = null;
    /** @var array<User> */
    private array $members = [];

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->user = null;
        $this->station = null;
        $this->channel = null;
        $this->message = null;
        $this->members = [];

        $this->persistence->clear();
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

        $this->channel = new Channel(
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
     * @Given I am not member of the channel
     */
    public function iAmNotMemberOfTheChannel(): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        if (null === $this->user) {
            throw new RuntimeException('No user authenticated during this scenario.');
        }
    }

    /**
     * @Given I have posted the message ":content" in the channel
     */
    public function iHavePostedMessageInChannel(string $content): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        if (null === $this->user) {
            throw new RuntimeException('No user authenticated during this scenario.');
        }

        $this->message = new ModelMessage(
            author: $this->user,
            content: $content,
            channel: $this->channel
        );

        $this->persistence->messages->add($this->message);
    }

    /**
     * @Given One member of the channel have posted the message ":content"
     */
    public function oneMemberOfTheChannelHavePostedMessage(string $content): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        if (count($this->members) === 0) {
            throw new RuntimeException('No members created during this scenario.');
        }

        $member = current($this->members);

        $this->message = new ModelMessage(
            author: $member,
            content: $content,
            channel: $this->channel
        );

        $this->persistence->messages->add($this->message);
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

            $this->members[] = $member;
        }

        $this->persistence->manager->flush();
    }

    /**
     * @When I delete the message
     */
    public function iDeleteTheMessage(): void
    {
        if (null === $this->message) {
            throw new RuntimeException('No message created during this scenario.');
        }

        $id = (string) $this->message->getIdentifier();

        $this->http->delete("/message/{$id}");
    }

    /**
     * @When I post the message ":content" in the channel
     */
    public function iPostAMessageInTheChannel(string $content): void
    {
        if (null === $this->channel) {
            throw new RuntimeException('No channel created during this scenario.');
        }

        if (null === $this->user) {
            throw new RuntimeException('No user authenticated during this scenario.');
        }

        $id = (string) $this->channel->getIdentifier();

        $this->http->post(
            uri: "/channel/{$id}/messages",
            content: [ 'content' => $content ]
        );
    }

    /**
     * @Then I should be notified that the message is created
     */
    public function iShouldBeNotifiedThatTheMessageIsCreated(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_CREATED);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'message-item'
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
     * @Then I should be notified that the message is deleted
     */
    public function iShouldBeNotifiedThatTheMessageIsDeleted(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_NO_CONTENT);
    }
}
