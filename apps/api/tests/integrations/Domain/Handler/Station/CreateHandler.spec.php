<?php

use Application\Synchronization;
use Application\Synchronization\Hub;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Message\Station\Create;
use Domain\Handler\Station\CreateHandler;
use Domain\Model\Station;
use Domain\Repository\Stations;

describe(CreateHandler::class, function() {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->hub->clean();
    });

    given('stations', fn () => $this->container->get(Stations::class));
    given('hub', fn () => $this->container->get(Hub::class));

    it ('create a new station in database', function () {
        $message = new Create('Private Station', 'station desc');

        /** @var Station $createdStation */
        $createdStation = $this->bus->execute($message);
        $persistedStation = $this->stations->find($createdStation->getIdentifier());

        expect($persistedStation === null)->toBeFalsy();
        expect($persistedStation->getName())->toBe('Private Station');
        expect($persistedStation->getDescription())->toBe('station desc');

        $syncPushes = $this->hub->getQueue();
        expect(count($syncPushes))->toBe(1);

        $push = $syncPushes[0];
        expect($push)->toBeAnInstanceOf(Synchronization\Push\Station::class);
        expect($push->getIdentifier())->toBe((string) $createdStation->getIdentifier());
        expect($push->getType())->toBe(Synchronization\Type::INSERT);
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
