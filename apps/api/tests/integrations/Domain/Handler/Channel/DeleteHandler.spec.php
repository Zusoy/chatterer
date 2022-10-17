<?php

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
    });

    given('channels', fn () => $this->container->get(Channels::class));

    it ('deletes channel from database', function () {
        $station = new Station('Station', 'desc');
        $channel = new Channel($station, 'My Channel', 'desc');

        $this->em->persist($station);
        $this->em->persist($channel);
        $this->em->flush();

        $message = new Delete($channel->getIdentifier());
        $this->bus->execute($message);

        $channel = $this->channels->find($channel->getIdentifier());

        expect(null === $channel)->toBeTruthy();
    });

    it ('throws if channel not found from database', function () {
        $message = new Delete('493e66a5-e2e6-4f59-afc1-6fefcc679361');

        $closure = function () use ($message) {
            $this->bus->execute($message);
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Channel', '493e66a5-e2e6-4f59-afc1-6fefcc679361'));
    });
});
