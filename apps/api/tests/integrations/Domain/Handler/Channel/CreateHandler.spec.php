<?php

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Message\Channel\Create;
use Domain\Handler\Channel\CreateHandler;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Repository\Channels;

describe(CreateHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('channels', fn () => $this->container->get(Channels::class));

    it ('create a new channel in database', function () {
        $station = new Station('Station', 'desc');
        $this->em->persist($station);
        $this->em->flush();

        $message = new Create($station->getIdentifier(), 'Channel', 'desc');

        /** @var Channel */
        $createdChannel = $this->bus->execute($message);
        $persistedChannel = $this->channels->find($createdChannel->getIdentifier());

        expect($persistedChannel === null)->toBeFalsy();
        expect($persistedChannel->getName())->toBe('Channel');
        expect($persistedChannel->getDescription())->toBe('desc');
        expect($persistedChannel->getStationIdentifier())->toBe($station->getIdentifier());
    });

    it ('throws if channel already exists in database', function () {
        $station = new Station('Station', 'desc');
        $channel = new Channel($station, 'My Channel', 'desc');

        $this->em->persist($station);
        $this->em->persist($channel);
        $this->em->flush();

        $message = new Create($station->getIdentifier(), 'My Channel', 'other');
        expect(fn () => $this->bus->execute($message))->toThrow(new ObjectAlreadyExistsException('Channel', 'My Channel'));
    });

    it ('throws if station not found in database', function () {
        $message = new Create('bce67778-058e-4ff8-ac02-70959a76de16', 'Channel', 'test');

        expect(fn () => $this->bus->execute($message))
            ->toThrow(new ObjectNotFoundException('Station', 'bce67778-058e-4ff8-ac02-70959a76de16'));
    });
});
