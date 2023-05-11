<?php

declare(strict_types=1);

use Domain\Command\Station\Update;
use Domain\CommandHandler\Station\UpdateHandler;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
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
        $identifier = $station->getIdentifier();

        $this->em->persist($station);
        $this->em->flush();

        $command = new Update((string) $identifier, 'New station', 'new desc');
        $this->bus->execute($command);

        $station = $this->stations->find($identifier);

        expect($station === null)->toBeFalsy();
        expect($station->getName())->toBe('New station');
        expect($station->getDescription())->toBe('new desc');
    });

    it ('throws when station not found from database', function () {
        $command = new Update('493e66a5-e2e6-4f59-afc1-6fefcc679361', 'Test', null);

        $closure = function () use ($command) {
            $this->bus->execute($command);
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Station', '493e66a5-e2e6-4f59-afc1-6fefcc679361'));
    });

    it ('throws if station already exist in database', function () {
        $station = new Station('Name', 'desc');
        $identifier = $station->getIdentifier();
        $this->em->persist($station);
        $this->em->flush();

        $closure = function () use ($identifier) {
            $this->bus->execute(new Update((string) $identifier, 'Name', 'other'));
        };

        expect($closure)->toThrow(new ObjectAlreadyExistsException('Station', 'Name'));
    });
});
