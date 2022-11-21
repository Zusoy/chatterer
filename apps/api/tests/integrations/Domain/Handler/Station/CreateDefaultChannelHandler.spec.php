<?php

use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Message\Station\CreateDefaultChannel;
use Domain\Handler\Station\CreateDefaultChannelHandler;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Repository\Channels;

describe(CreateDefaultChannelHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->events->clean();
    });

    given('channels', fn () => $this->container->get(Channels::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('creates default channel in station', function () {
        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);
        $this->em->flush();

        $message = new CreateDefaultChannel($station->getIdentifier());
        $this->bus->execute($message);

        $channel = $this->channels->findByName($station->getIdentifier(), Channel::GENERAL_DEFAULT_NAME);

        expect(null === $channel)->toBeFalsy();
        expect($channel->getName())->toBe(Channel::GENERAL_DEFAULT_NAME);
        expect($channel->getStationIdentifier())->toBe($station->getIdentifier());

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);

        expect($events[0])->toMatch(function (mixed $actual) use ($channel): bool {
            return $actual instanceof \Domain\Event\Channel\Created &&
                $actual->channel->getIdentifier() === $channel->getIdentifier()
            ;
        });
    });

    it ('throws if station not found from database', function () {
        $identifier = Identifier::generate();

        expect(fn () => $this->bus->execute(new CreateDefaultChannel(id: $identifier)))
            ->toThrow(new ObjectNotFoundException('Station', $identifier));
    });
});
