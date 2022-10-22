<?php

use Application\Synchronization;
use Application\Synchronization\Hub;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler\Message\CreateHandler;
use Domain\Identity\Identifier;
use Domain\Message\Message\Create;
use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\Station;
use Domain\Repository\Messages;

describe(CreateHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->hub->clean();
    });

    given('messages', fn () => $this->container->get(Messages::class));
    given('hub', fn () => $this->container->get(Hub::class));

    it ('create new message in database', function () {
        $station = new Station('Station', 'desc');
        $this->em->persist($station);

        $channel = new Channel($station, name: 'Channel', description: null);
        $this->em->persist($channel);
        $this->em->flush();

        $message = new Create(
            channelId: $channel->getIdentifier(),
            content: 'Hello World'
        );
        /** @var Message */
        $newMessage = $this->bus->execute($message);
        $persistedMessage = $this->messages->find($newMessage->getIdentifier());

        expect(null === $persistedMessage)->toBeFalsy();
        expect($persistedMessage->getContent())->toBe('Hello World');
        expect($persistedMessage->getChannelIdentifier())->toBe($channel->getIdentifier());
        expect($persistedMessage->getChannelName())->toBe($channel->getName());

        $syncPushes = $this->hub->getQueue();
        expect(count($syncPushes))->toBe(1);

        $push = $syncPushes[0];
        expect($push)->toBeAnInstanceOf(Synchronization\Push\Message::class);
        expect($push->getIdentifier())->toBe((string) $newMessage->getIdentifier());
        expect($push->getType())->toBe(Synchronization\Type::INSERT);
    });

    it ('throws if channel not found from database', function () {
        $station = new Station('Station', 'desc');
        $this->em->persist($station);
        $this->em->flush();

        $identifier = Identifier::generate();

        expect(fn () => $this->bus->execute(new Create(
            channelId: (string) $identifier,
            content: 'Hello !'
        )))->toThrow(new ObjectNotFoundException('Channel', $identifier));
    });
});
