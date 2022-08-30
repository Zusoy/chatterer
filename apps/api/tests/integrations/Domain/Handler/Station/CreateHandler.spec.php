<?php

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Message\Station\Create;
use Domain\Handler\Station\CreateHandler;
use Domain\Model\Station;
use Domain\Repository\Stations;

describe(CreateHandler::class, function() {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('stations', fn () => $this->container->get(Stations::class));

    it ('create a new station in database', function () {
        $command = new Create('Private Station', 'station desc');

        /** @var Station $createdStation */
        $createdStation = $this->bus->execute($command);
        $persistedStation = $this->stations->find($createdStation->getId());

        expect($persistedStation === null)->toBeFalsy();
        expect($persistedStation->getName())->toBe('Private Station');
        expect($persistedStation->getDescription())->toBe('station desc');
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
