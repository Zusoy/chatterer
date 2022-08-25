<?php

use Domain\Exception\ObjectNotFoundException;
use Domain\Message\Station\Update;
use Domain\Handler\Station\UpdateHandler;
use Domain\Model\Station;
use Domain\Repository\Stations;

describe(UpdateHandler::class, function() {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('stations', fn () => $this->container->get(Stations::class));

    it ('updates station from database', function () {
        $station = new Station('My station', 'my desc');
        $identifier = $station->getId();
        $updatedDate = $station->getUpdatedAt();

        $this->em->persist($station);
        $this->em->flush();

        $message = new Update($identifier, 'New station', 'new desc');
        $this->bus->execute($message);

        $station = $this->stations->find($identifier);

        expect($station === null)->toBeFalsy();
        expect($station->getName())->toBe('New station');
        expect($station->getDescription())->toBe('new desc');
        expect($station->getUpdatedAt() === $updatedDate)->toBeFalsy();
    });

    it ('throws when station not found from database', function () {
        $message = new Update('493e66a5-e2e6-4f59-afc1-6fefcc679361', 'Test', null);

        $closure = function () use ($message) {
            $this->bus->execute($message);
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Station', '493e66a5-e2e6-4f59-afc1-6fefcc679361'));
    });
});