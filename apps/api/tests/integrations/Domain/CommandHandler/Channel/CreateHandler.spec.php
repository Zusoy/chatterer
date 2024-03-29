<?php

declare(strict_types=1);

use Application\Synchronization;
use Application\Synchronization\Hub;
use Domain\Command\Channel\Create;
use Domain\CommandHandler\Channel\CreateHandler;
use Domain\EventLog;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Repository\Channels;

describe(CreateHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->hub->clean();
        $this->events->clean();
    });

    given('channels', fn () => $this->container->get(Channels::class));
    given('hub', fn () => $this->container->get(Hub::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('create a new channel in database', function () {
        $station = new Station('Station', 'desc');
        $this->em->persist($station);
        $this->em->flush();

        $command = new Create((string) $station->getIdentifier(), 'Channel', 'desc');

        /** @var Channel */
        $createdChannel = $this->bus->execute($command);
        $persistedChannel = $this->channels->find($createdChannel->getIdentifier());

        expect($persistedChannel === null)->toBeFalsy();
        expect($persistedChannel->getName())->toBe('Channel');
        expect($persistedChannel->getDescription())->toBe('desc');
        expect($persistedChannel->getStationIdentifier())->toBe($station->getIdentifier());

        $syncPushes = $this->hub->getQueue();
        expect(count($syncPushes))->toBe(1);

        $push = $syncPushes[0];
        expect($push)->toBeAnInstanceOf(Synchronization\Push\Channel::class);
        expect($push->getIdentifier())->toBe((string) $createdChannel->getIdentifier());
        expect($push->getType())->toBe(Synchronization\Type::INSERT);

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);
        expect($events[0])->toMatch(function (mixed $actual) use ($createdChannel): bool {
            return $actual instanceof \Domain\Event\Channel\Created &&
                $actual->channel->getIdentifier() === $createdChannel->getIdentifier()
            ;
        });
    });

    it ('throws if channel already exists in database', function () {
        $station = new Station('Station', 'desc');
        $channel = new Channel($station, 'My Channel', 'desc');

        $this->em->persist($station);
        $this->em->persist($channel);
        $this->em->flush();

        $command = new Create((string) $station->getIdentifier(), 'My Channel', 'other');
        expect(fn () => $this->bus->execute($command))->toThrow(new ObjectAlreadyExistsException('Channel', 'My Channel'));
    });

    it ('throws if station not found in database', function () {
        $command = new Create('bce67778-058e-4ff8-ac02-70959a76de16', 'Channel', 'test');

        expect(fn () => $this->bus->execute($command))
            ->toThrow(new ObjectNotFoundException('Station', 'bce67778-058e-4ff8-ac02-70959a76de16'));
    });
});
