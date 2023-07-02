<?php

declare(strict_types=1);

use Domain\Command\Station\Join;
use Domain\CommandHandler\Station\JoinHandler;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\UserAlreadyJoinedException;
use Domain\Model\Invitation;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Repository\Users;

describe(JoinHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->events->clean();
    });

    given('users', fn () => $this->container->get(Users::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('adds user in station with invitation', function () {
        $user = new User(
            firstname: 'Test',
            lastname: 'Test',
            email: 'test@gmail.com',
            password: 'test'
        );

        $station = new Station(
            name: 'Company',
            description: null
        );

        $invitation = new Invitation($station);

        $this->em->persist($station);
        $this->em->persist($user);
        $this->em->persist($invitation);
        $this->em->flush();

        $command = new Join(
            userId: (string) $user->getIdentifier(),
            invitationToken: (string) $invitation->getToken()
        );

        $this->bus->execute($command);

        /** @var User */
        $user = $this->users->find($user->getIdentifier());

        expect($user->isInStation($station))->toBe(true);

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);

        expect($events[0])->toMatch(function (mixed $actual) use ($station, $user): bool {
            return $actual instanceof \Domain\Event\Station\NewMember &&
                $actual->station->getIdentifier() === $station->getIdentifier() &&
                $actual->user->getIdentifier() === $user->getIdentifier()
            ;
        });
    });

    it ('throws when user not found from database', function () {
        $closure = function () {
            $this->bus->execute(new Join(
                userId: '05a5e2bd-f924-44c2-8327-06a6b80ef5b2',
                invitationToken: 'token'
            ));
        };

        expect($closure)->toThrow(new ObjectNotFoundException('User', '05a5e2bd-f924-44c2-8327-06a6b80ef5b2'));
    });

    it ('throws when invitation not found from database', function () {
        $user = new User(
            firstname: 'Test',
            lastname: 'Test',
            email: 'test@gmail.com',
            password: 'test'
        );

        $this->em->persist($user);
        $this->em->flush();

        $closure = function () use ($user) {
            $this->bus->execute(new Join(
                userId: (string) $user->getIdentifier(),
                invitationToken: 'notexistingtoken'
            ));
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Invitation', 'notexistingtoken'));
    });

    it ('throws if user is already member of the station', function () {
        $user = new User(
            firstname: 'Test',
            lastname: 'Test',
            email: 'test@gmail.com',
            password: 'test'
        );

        $station = new Station(
            name: 'Company',
            description: null
        );

        $user->joinGroup($station);

        $invitation = new Invitation($station);

        $this->em->persist($user);
        $this->em->persist($station);
        $this->em->persist($invitation);
        $this->em->flush();

        $closure = function () use ($user, $invitation) {
            $this->bus->execute(new Join(
                userId: (string) $user->getIdentifier(),
                invitationToken: (string) $invitation->getToken()
            ));
        };

        expect($closure)->toThrow(new UserAlreadyJoinedException($station, $user));
    });
});
