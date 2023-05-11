<?php

declare(strict_types=1);

use Domain\Command\Station\CreateDefaultChannel;
use Domain\CommandHandler\Station\CreateDefaultChannelHandler;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Identity\Identifier;
use Domain\Model\Station;
use Domain\Repository\Channels;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

describe(CreateDefaultChannelHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->events->clean();
    });

    given('channels', fn () => $this->container->get(Channels::class));
    given('events', fn () => $this->container->get(EventLog::class));
    given('parameters', fn () => $this->container->get(ParameterBagInterface::class));

    it ('creates default channel in station', function () {
        $defaultChannelName = $this->parameters->get('default_channel_name');

        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);
        $this->em->flush();

        $command = new CreateDefaultChannel((string) $station->getIdentifier());
        $this->bus->execute($command);

        $channel = $this->channels->findByName($station->getIdentifier(), $defaultChannelName);

        expect(null === $channel)->toBeFalsy();
        expect($channel->getName())->toBe($defaultChannelName);
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

        expect(fn () => $this->bus->execute(new CreateDefaultChannel(id: (string) $identifier)))
            ->toThrow(new ObjectNotFoundException('Station', (string) $identifier));
    });
});
