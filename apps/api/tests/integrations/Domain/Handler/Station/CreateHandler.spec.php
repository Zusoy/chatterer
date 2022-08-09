<?php

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
});
