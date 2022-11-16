<?php

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler\Channel\ListUsersHandler;
use Domain\Identity\Identifier;
use Domain\Message\Channel\ListUsers;
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

        $firstUser->joinStation($station);
        $firstUser->joinChannel($channel);

        $secondUser->joinStation($station);
        $secondUser->joinChannel($channel);

        $this->em->persist($firstUser);
        $this->em->persist($secondUser);

        $this->em->flush();

        $message = new ListUsers(id: $channel->getIdentifier());
        $users = $this->bus->execute($message);

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
            id: $identifier
        ));

        expect($closure)->toThrow(new ObjectNotFoundException('Channel', (string) $identifier));
    });
});
