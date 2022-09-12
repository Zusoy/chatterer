<?php

use Domain\Exception\ObjectNotFoundException;
use Domain\Message\Station\Delete;
use Domain\Handler\Station\DeleteHandler;
use Domain\Model\Station;
use Domain\Repository\Stations;

describe(DeleteHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('stations', fn () => $this->container->get(Stations::class));

    it ('deletes station from database', function () {
        $station = new Station('Name', 'desc');
        $identifier = $station->getIdentifier();

        $this->em->persist($station);
        $this->em->flush();

        $message = new Delete($identifier);
        $this->bus->execute($message);

        $station = $this->stations->find($identifier);

        expect(null === $station)->toBeTruthy();
    });

    it ('throws when station not found in database', function () {
        $message = new Delete('493e66a5-e2e6-4f59-afc1-6fefcc679361');

        $closure = function () use ($message) {
            $this->bus->execute($message);
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Station', '493e66a5-e2e6-4f59-afc1-6fefcc679361'));
    });
});
