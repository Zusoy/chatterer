<?php

declare(strict_types=1);

use Domain\Command\Channel\ListUsers;
use Domain\CommandHandler\Channel\ListUsersHandler;
use Domain\Exception\ObjectNotFoundException;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Model\User;

describe(ListUsersHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    it ('retrieves channel users', function () {
        $station = new Station(name: 'Station', description: null);
        $channel = new Channel($station, name: 'Channel', description: null);

        $this->em->persist($station);
        $this->em->persist($channel);

        $firstUser = new User(
            firstname: 'Hello',
            lastname: 'World',
            email: 'h.w@gmail.com',
            password: 'hello'
        );

        $secondUser = new User(
            firstname: 'Bye',
            lastname: 'World',
            email: 'b.w@gmail.com',
            password: 'hello'
        );

        $firstUser->joinGroup($station);
        $firstUser->joinGroup($channel);

        $secondUser->joinGroup($station);
        $secondUser->joinGroup($channel);

        $this->em->persist($firstUser);
        $this->em->persist($secondUser);

        $this->em->flush();

        $command = new ListUsers(id: (string) $channel->getIdentifier());
        $users = $this->bus->execute($command);

        expect(count($users))->toBe(2);
        expect($users[0])->toMatch(function (mixed $actual) use ($firstUser): bool {
            return $actual instanceof User &&
                $actual->getIdentifier() === $firstUser->getIdentifier()
            ;
        });
        expect($users[1])->toMatch(function (mixed $actual) use ($secondUser): bool {
            return $actual instanceof User &&
                $actual->getIdentifier() === $secondUser->getIdentifier()
            ;
        });
    });

    it ('throws if channel not found from database', function () {
        $identifier = Identifier::generate();

        $closure = fn () => $this->bus->execute(new ListUsers(
            id: (string) $identifier
        ));

        expect($closure)->toThrow(new ObjectNotFoundException('Channel', (string) $identifier));
    });
});
