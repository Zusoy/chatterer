<?php

use Application\Synchronization;
use Application\Synchronization\Hub;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler\Message\CreateHandler;
use Domain\Identity\Identifier;
use Domain\Message\Message\Create;
use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Repository\Messages;

describe(CreateHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->hub->clean();
        $this->events->clean();
    });

    given('messages', fn () => $this->container->get(Messages::class));
    given('hub', fn () => $this->container->get(Hub::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('create new message in database', function () {
        $station = new Station('Station', 'desc');
        $this->em->persist($station);

        $channel = new Channel($station, name: 'Channel', description: null);
        $this->em->persist($channel);
        $this->em->flush();

        $author = new User(
            firstname: 'Hello',
            lastname: 'World',
            email: 'hello.world@gmail.com',
            password: 'Hello@123'
        );
        $this->em->persist($author);

        $message = new Create(
            authorId: $author->getIdentifier(),
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
        expect($persistedMessage->getAuthorIdentifier())->toBe($author->getIdentifier());

        $syncPushes = $this->hub->getQueue();
        expect(count($syncPushes))->toBe(1);

        $push = $syncPushes[0];
        expect($push)->toBeAnInstanceOf(Synchronization\Push\Message::class);
        expect($push->getIdentifier())->toBe((string) $newMessage->getIdentifier());
        expect($push->getType())->toBe(Synchronization\Type::INSERT);

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);
        expect($events[0])->toMatch(function (mixed $actual) use ($newMessage): bool {
            return $actual instanceof \Domain\Event\Message\Created &&
                $actual->message->getIdentifier() === $newMessage->getIdentifier()
            ;
        });
    });

    it ('throws if author not found from database', function () {
        expect(fn () => $this->bus->execute(new Create(
            authorId: '6d683ee5-5d60-4b67-8935-34b59cb834f9',
            channelId: '6d683ee5-5d60-4b67-8935-34b59cb834f9',
            content: 'Hello !'
        )))->toThrow(new ObjectNotFoundException('User', '6d683ee5-5d60-4b67-8935-34b59cb834f9'));
    });

    it ('throws if channel not found from database', function () {
        $station = new Station('Station', 'desc');
        $this->em->persist($station);
        $this->em->flush();

        $author = new User(
            firstname: 'Hello',
            lastname: 'World',
            email: 'hello.world@gmail.com',
            password: 'Hello@123'
        );
        $this->em->persist($author);

        $identifier = Identifier::generate();

        expect(fn () => $this->bus->execute(new Create(
            authorId: $author->getIdentifier(),
            channelId: (string) $identifier,
            content: 'Hello !'
        )))->toThrow(new ObjectNotFoundException('Channel', $identifier));
    });
});
