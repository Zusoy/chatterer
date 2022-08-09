<?php

use Domain\Message\Station\All;
use Domain\Handler\Station\AllHandler;
use Domain\Model\Station;

describe(AllHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    it ('provides stations from database', function () {
        $firstStation = new Station('First', 'desc');
        $secondStation = new Station('Second', 'desc');

        $this->em->persist($firstStation);
        $this->em->persist($secondStation);
        $this->em->flush();

        $message = new All();
        $stations = $this->bus->execute($message);

        expect(count($stations))->toBe(2);
    });
});
