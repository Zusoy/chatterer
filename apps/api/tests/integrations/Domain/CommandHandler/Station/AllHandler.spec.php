<?php

declare(strict_types=1);

use Domain\Command\Station\All;
use Domain\CommandHandler\Station\AllHandler;
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

        $command = new All();
        $stations = $this->bus->execute($command);

        expect(count($stations))->toBe(2);
    });
});
