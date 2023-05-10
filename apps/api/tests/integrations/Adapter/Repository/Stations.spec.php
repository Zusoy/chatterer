<?php

declare(strict_types=1);

use Domain\Repository\Stations;
use Domain\Model\Station;

describe(Stations::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given ('subject', fn () => $this->container->get(Stations::class));

    it ('finds station in database by id', function () {
        $station = new Station('NAME', 'desc');
        $identifier = $station->getIdentifier();
        $this->em->persist($station);
        $this->em->flush();

        $station = $this->subject->find($identifier);

        expect(null === $station)->toBeFalsy();
        expect((string)$station->getIdentifier())->toBe((string)$identifier);
        expect($station->getName())->toBe('NAME');
        expect($station->getDescription())->toBe('desc');
    });

    it ('finds all stations from database', function () {
        $station1 = new Station('STATION One', 'desc');
        $station2 = new Station('STATION Two', 'other');

        $this->em->persist($station1);
        $this->em->persist($station2);
        $this->em->flush();

        $stations = $this->subject->findAll();

        expect(count($stations))->toBe(2);
    });

    it ('removes station from database', function () {
        $station = new Station('NAME', 'desc');
        $identifier = $station->getIdentifier();
        $this->em->persist($station);
        $this->em->flush();

        $this->subject->remove($station);

        expect($this->subject->find($identifier))->toBeNull();
    });
});
