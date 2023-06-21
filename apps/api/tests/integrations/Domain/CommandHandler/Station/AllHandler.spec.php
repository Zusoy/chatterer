<?php

declare(strict_types=1);

use Domain\Command\Station\All;
use Domain\CommandHandler\Station\AllHandler;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Model\User\Role;

describe(AllHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    it ('provides all stations from database as admin', function () {
        $firstStation = new Station('First', 'desc');
        $secondStation = new Station('Second', 'desc');

        $admin = new User(
            firstname: 'test',
            lastname: 'admin',
            email: 'admin@test.com',
            password: 'test'
        );

        $admin->setRole(Role::ADMIN);

        $this->em->persist($admin);
        $this->em->persist($firstStation);
        $this->em->persist($secondStation);
        $this->em->flush();

        $command = new All(userId: (string) $admin->getIdentifier());
        $stations = $this->bus->execute($command);

        expect(count($stations))->toBe(2);
    });

    it ('provides only joined station as regular user', function () {
        $firstStation = new Station('First', 'desc');
        $secondStation = new Station('Second', 'desc');

        $user = new User(
            firstname: 'test',
            lastname: 'admin',
            email: 'admin@test.com',
            password: 'test'
        );

        $user->joinGroup($firstStation);

        $this->em->persist($user);
        $this->em->persist($firstStation);
        $this->em->persist($secondStation);
        $this->em->flush();

        $command = new All(userId: (string) $user->getIdentifier());
        $stations = $this->bus->execute($command);

        expect(count($stations))->toBe(1);
    });
});
