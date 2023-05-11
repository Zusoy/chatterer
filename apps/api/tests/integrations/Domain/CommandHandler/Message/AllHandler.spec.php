<?php

declare(strict_types=1);

use Domain\Command\Message\All;
use Domain\CommandHandler\Message\AllHandler;
use Domain\Exception\ObjectNotFoundException;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\Station;
use Domain\Model\User;

describe(AllHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    it ('retrieves all channel messages', function () {
        $station = new Station(name: 'Station', description: 'desc');
        $this->em->persist($station);

        $channel = new Channel(
            station: $station,
            name: 'general',
            description: null
        );
        $this->em->persist($channel);

        $author = new User(
            firstname: 'Hello',
            lastname: 'World',
            email: 'hello.world@gmail.com',
            password: 'Hello@123'
        );
        $this->em->persist($author);

        $firstMessage = new Message(author: $author, content: 'Hello', channel: $channel);
        $secondMessage = new Message(author: $author, content: 'Hi !', channel: $channel);
        $this->em->persist($firstMessage);
        $this->em->persist($secondMessage);
        $this->em->flush();

        $command = new All(channelId: (string) $channel->getIdentifier());
        $messages = $this->bus->execute($command);

        expect(count($messages))->toBe(2);
    });

    it ('throws if channel not found from database', function () {
        $identifier = Identifier::generate();

        expect(fn () => $this->bus->execute(new All(
            channelId: (string) $identifier
        )))->toThrow(new ObjectNotFoundException('Channel', (string) $identifier));
    });
});
