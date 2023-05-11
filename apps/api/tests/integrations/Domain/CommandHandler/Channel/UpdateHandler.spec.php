<?php

declare(strict_types=1);

use Domain\Command\Channel\Update;
use Domain\CommandHandler\Channel\UpdateHandler;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Repository\Channels;

describe(UpdateHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('channels', fn () => $this->container->get(Channels::class));

    it ('updates an channel from database', function () {
        $station = new Station('Station', 'desc');
        $channel = new Channel($station, 'My Channel', 'desc');

        $this->em->persist($station);
        $this->em->persist($channel);
        $this->em->flush();

        $command = new Update((string) $channel->getIdentifier(), 'New Name', 'new desc');
        $this->bus->execute($command);

        $channel = $this->channels->find($channel->getIdentifier());

        expect($channel === null)->toBeFalsy();
        expect($channel->getName())->toBe('New Name');
        expect($channel->getDescription())->toBe('new desc');
    });

    it ('throws if channel name already exists from database', function () {
        $station = new Station('Station', 'desc');
        $firstChannel = new Channel($station, 'My Channel', 'desc');
        $secondChannel = new Channel($station, 'Other Channel', 'desc');

        $this->em->persist($station);
        $this->em->persist($firstChannel);
        $this->em->persist($secondChannel);
        $this->em->flush();

        $command = new Update((string) $firstChannel->getIdentifier(), 'Other Channel', 'new desc');
        expect(fn () => $this->bus->execute($command))
            ->toThrow(new ObjectAlreadyExistsException('Channel', 'Other Channel'));
    });
});
