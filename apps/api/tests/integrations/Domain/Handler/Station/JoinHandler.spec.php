<?php

use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\UserAlreadyJoinedException;
use Domain\Message\Station\Join;
use Domain\Handler\Station\JoinHandler;
use Domain\Model\Invitation;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Repository\Invitations;
use Domain\Repository\Stations;
use Domain\Repository\Users;

describe(JoinHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->events->clean();
    });

    given('stations', fn () => $this->container->get(Stations::class));
    given('users', fn () => $this->container->get(Users::class));
    given('invitations', fn () => $this->container->get(Invitations::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('add user in station and removes user invitation', function () {
        $station = new Station(name: 'Hello', description: null);
        $this->em->persist($station);

        $invitation = new Invitation($station);
        $this->em->persist($invitation);

        $user = new User(
            firstname: 'John',
            lastname: 'Doe',
            email: 'john.doe@gmail.com',
            password: 'helloworld@123'
        );
        $this->em->persist($user);
        $this->em->flush();

        $message = new Join(
            stationId: $station->getIdentifier(),
            userId: $user->getIdentifier(),
            token: $invitation->getToken()
        );

        $this->bus->execute($message);

        /** @var Station */
        $station = $this->stations->find($station->getIdentifier());

        /** @var User */
        $user = $this->users->find($user->getIdentifier());

        expect($station === null)->toBeFalsy();
        expect($user === null)->toBeFalsy();
        expect($station->has($user))->toBeTruthy();

        $invitation = $this->invitations->findByToken($invitation->getToken(), $station);
        expect($invitation === null)->toBeTruthy();

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);

        expect($events[0])->toMatch(function (mixed $actual) use ($user, $station): bool {
            return $actual instanceof \Domain\Event\Station\NewMember &&
                $actual->user->getIdentifier() === $user->getIdentifier() &&
                $actual->station->getIdentifier() === $station->getIdentifier()
            ;
        });
    });

    it ('throws when station not found from database', function () {
        expect(fn () => $this->bus->execute(new Join(
            stationId: 'a1bb4fa1-3a2a-4045-a66e-3435da68a00a',
            userId: 'a1bb4fa1-3a2a-4045-a66e-3435da68a00a',
            token: 'stationToken'
        )))->toThrow(new ObjectNotFoundException('Station', 'a1bb4fa1-3a2a-4045-a66e-3435da68a00a'));
    });

    it ('throws when user not found from database', function () {
        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);
        $this->em->flush();

        expect(fn () => $this->bus->execute(new Join(
            stationId: $station->getIdentifier(),
            userId: 'a1bb4fa1-3a2a-4045-a66e-3435da68a00a',
            token: 'stationToken'
        )))->toThrow(new ObjectNotFoundException('User', 'a1bb4fa1-3a2a-4045-a66e-3435da68a00a'));
    });

    it ('throws when invitation not found from database', function () {
        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);

        $user = new User(
            firstname: 'John',
            lastname: 'Doe',
            email: 'john.doe@gmail.com',
            password: 'helloworld@123'
        );
        $this->em->persist($user);
        $this->em->flush();

        expect(fn () => $this->bus->execute(new Join(
            stationId: $station->getIdentifier(),
            userId: $user->getIdentifier(),
            token: 'stationToken'
        )))->toThrow(new ObjectNotFoundException('Invitation', 'stationToken'));
    });

    it ('throws if user already joined the station', function () {
        $station = new Station(name: 'Hello', description: null);
        $this->em->persist($station);

        $invitation = new Invitation($station);
        $this->em->persist($invitation);

        $user = new User(
            firstname: 'John',
            lastname: 'Doe',
            email: 'john.doe@gmail.com',
            password: 'helloworld@123'
        );
        $this->em->persist($user);

        $user->joinStation($station);

        $this->em->flush();

        expect(fn () => $this->bus->execute(new Join(
            stationId: $station->getIdentifier(),
            userId: $user->getIdentifier(),
            token: $invitation->getToken()
        )))->toThrow(new UserAlreadyJoinedException($station, $user));
    });
});
