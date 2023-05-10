<?php

declare(strict_types=1);

use Domain\Handler\Station\ListUsersHandler;
use Domain\Message\Station\ListUsers;
use Domain\Model\Station;
use Domain\Model\User;

describe(ListUsersHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    it ('retrieves all station users', function () {
        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);

        $user = new User(
            firstname: 'John',
            lastname: 'Doe',
            email: 'john.doe@gmail.com',
            password: 'helloworld@123'
        );

        $user->joinStation($station);

        $this->em->persist($user);
        $this->em->flush();

        $message = new ListUsers(id: (string) $station->getIdentifier());
        $users = $this->bus->execute($message);

        expect($users)->toHaveLength(1);
        expect($users[0])->toMatch(function (mixed $actual) use ($user): bool {
            return $actual instanceof User &&
                $actual->getIdentifier() === $user->getIdentifier()
            ;
        });
    });
});
