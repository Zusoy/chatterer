<?php

use Application\Synchronization;
use Application\Synchronization\Hub;
use Domain\EventLog;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Message\Station\Create;
use Domain\Handler\Station\CreateHandler;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Repository\Channels;
use Domain\Repository\Stations;

describe(CreateHandler::class, function() {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->hub->clean();
        $this->events->clean();
    });

    given('stations', fn () => $this->container->get(Stations::class));
    given('channels', fn () => $this->container->get(Channels::class));
    given('hub', fn () => $this->container->get(Hub::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('create a new station in database with default channel', function () {
        $message = new Create('Private Station', 'station desc');

        /** @var Station $createdStation */
        $createdStation = $this->bus->execute($message);
        $persistedStation = $this->stations->find($createdStation->getIdentifier());

        /** @var Channel $defaultChannel */
        $defaultChannel = $this->channels->findByName($persistedStation->getIdentifier(), Channel::GENERAL_DEFAULT_NAME);

        expect(null === $defaultChannel)->toBeFalsy();
        expect($persistedStation === null)->toBeFalsy();
        expect($persistedStation->getName())->toBe('Private Station');
        expect($persistedStation->getDescription())->toBe('station desc');

        $syncPushes = $this->hub->getQueue();
        expect(count($syncPushes))->toBe(2);

        $push = $syncPushes[0];
        expect($push)->toBeAnInstanceOf(Synchronization\Push\Station::class);
        expect($push->getIdentifier())->toBe((string) $createdStation->getIdentifier());
        expect($push->getType())->toBe(Synchronization\Type::INSERT);

        $channelPush = $syncPushes[1];
        expect($channelPush)->toBeAnInstanceOf(Synchronization\Push\Channel::class);
        expect($channelPush->getIdentifier())->toBe((string) $defaultChannel->getIdentifier());
        expect($channelPush->getType())->toBe(Synchronization\Type::INSERT);

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(2);

        expect($events[0])->toMatch(function (mixed $actual) use ($defaultChannel): bool {
            return $actual instanceof \Domain\Event\Channel\Created &&
                $actual->channel->getIdentifier() === $defaultChannel->getIdentifier()
            ;
        });

        expect($events[1])->toMatch(function (mixed $actual) use ($createdStation): bool {
            return $actual instanceof \Domain\Event\Station\Created &&
                $actual->station->getIdentifier() === $createdStation->getIdentifier()
            ;
        });
    });

    it ('throws if station already exist in database', function () {
        $station = new Station('Name', 'desc');
        $this->em->persist($station);
        $this->em->flush();

        $closure = function () {
            $this->bus->execute(new Create('Name', 'other'));
        };

        expect($closure)->toThrow(new ObjectAlreadyExistsException('Station', 'Name'));
    });
});
