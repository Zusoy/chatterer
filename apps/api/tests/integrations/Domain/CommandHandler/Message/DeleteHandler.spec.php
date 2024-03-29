<?php

declare(strict_types=1);

use Application\Synchronization;
use Application\Synchronization\Hub;
use Domain\Command\Message\Delete;
use Domain\CommandHandler\Message\DeleteHandler;
use Domain\Exception\ObjectNotFoundException;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Repository\Messages;

describe(DeleteHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->hub->clean();
    });

    given('messages', fn () => $this->container->get(Messages::class));
    given('hub', fn () => $this->container->get(Hub::class));

    it ('deletes message from database', function () {
        $station = new Station('Station', 'desc');
        $this->em->persist($station);

        $channel = new Channel($station, 'Channel', 'desc');
        $this->em->persist($channel);

        $author = new User(
            firstname: 'Hello',
            lastname: 'World',
            email: 'hello.world@gmail.com',
            password: 'Hello@123'
        );
        $this->em->persist($author);

        $message = new Message(author: $author, content: 'Hello World !', channel: $channel);
        $identifier = $message->getIdentifier();
        $this->em->persist($message);
        $this->em->flush();

        $command = new Delete(id: (string) $message->getIdentifier());
        $this->bus->execute($command);

        $deletedMessage = $this->messages->find($identifier);

        expect(null === $deletedMessage)->toBeTruthy();

        $syncPushes = $this->hub->getQueue();
        expect(count($syncPushes))->toBe(1);

        $push = $syncPushes[0];
        expect($push)->toBeAnInstanceOf(Synchronization\Push\Message::class);
        expect($push->getIdentifier())->toBe((string) $message->getIdentifier());
        expect($push->getType())->toBe(Synchronization\Type::DELETE);
    });

    it ('throws if message not found from database', function () {
        $identifier = Identifier::generate();

        expect(fn () => $this->bus->execute(new Delete(
            id: (string) $identifier
        )))->toThrow(new ObjectNotFoundException('Message', (string) $identifier));
    });
});
