<?php

declare(strict_types=1);

use Application\Synchronization;
use Application\Synchronization\Hub;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler\Channel\DeleteHandler;
use Domain\Message\Channel\Delete;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Repository\Channels;

describe(DeleteHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->hub->clean();
        $this->events->clean();
    });

    given('channels', fn () => $this->container->get(Channels::class));
    given('hub', fn () => $this->container->get(Hub::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('deletes channel from database', function () {
        $station = new Station('Station', 'desc');
        $channel = new Channel($station, 'My Channel', 'desc');
        $identifier = $channel->getIdentifier();

        $this->em->persist($station);
        $this->em->persist($channel);
        $this->em->flush();

        $message = new Delete((string) $channel->getIdentifier());
        $this->bus->execute($message);

        $channel = $this->channels->find($channel->getIdentifier());

        expect(null === $channel)->toBeTruthy();

        $syncPushes = $this->hub->getQueue();
        expect(count($syncPushes))->toBe(1);

        $push = $syncPushes[0];
        expect($push)->toBeAnInstanceOf(Synchronization\Push\Channel::class);
        expect($push->getIdentifier())->toBe((string) $identifier);
        expect($push->getType())->toBe(Synchronization\Type::DELETE);

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);
        expect($events[0])->toMatch(function (mixed $actual) use ($identifier): bool {
            return $actual instanceof \Domain\Event\Channel\Deleted &&
                $actual->channel->getIdentifier() === $identifier
            ;
        });
    });

    it ('throws if channel not found from database', function () {
        $message = new Delete('493e66a5-e2e6-4f59-afc1-6fefcc679361');

        $closure = function () use ($message) {
            $this->bus->execute($message);
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Channel', '493e66a5-e2e6-4f59-afc1-6fefcc679361'));
    });
});
