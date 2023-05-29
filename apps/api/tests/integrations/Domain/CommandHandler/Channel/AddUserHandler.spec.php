<?php

declare(strict_types=1);

use Domain\Command\Channel\AddUser;
use Domain\CommandHandler\Channel\AddUserHandler;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Repository\Channels;
use Domain\Repository\Users;

describe(AddUserHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->events->clean();
    });

    given('users', fn () => $this->container->get(Users::class));
    given('channels', fn () => $this->container->get(Channels::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('adds user in channel', function () {
        $station = new Station(name: 'Station', description: null);
        $channel = new Channel($station, name: 'Channel', description: null);

        $this->em->persist($station);
        $this->em->persist($channel);

        $user = new User(
            firstname: 'Hello',
            lastname: 'World',
            email: 'h.w@gmail.com',
            password: 'hello'
        );
        $this->em->persist($user);
        $user->joinGroup($station);

        $this->em->flush();

        $command = new AddUser(
            channelId: (string) $channel->getIdentifier(),
            userId: (string) $user->getIdentifier()
        );
        $this->bus->execute($command);

        /** @var User */
        $user = $this->users->find($user->getIdentifier());
        /** @var Channel */
        $channel = $this->channels->find($channel->getIdentifier());

        expect(null === $user)->toBeFalsy();
        expect(null === $channel)->toBeFalsy();

        expect($channel->hasUser($user))->toBeTruthy();

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);

        expect($events[0])->toMatch(function (mixed $actual) use ($user, $channel): bool {
            return $actual instanceof \Domain\Event\Channel\NewMember &&
                $actual->channel->getIdentifier() === $channel->getIdentifier() &&
                $actual->user->getIdentifier() === $user->getIdentifier()
            ;
        });
    });

    it ('throws if channel not found from database', function () {
        $identifier = Identifier::generate();

        $closure = fn () => $this->bus->execute(new AddUser(
            channelId: (string) $identifier,
            userId: (string) $identifier
        ));

        expect($closure)->toThrow(new ObjectNotFoundException('Channel', (string) $identifier));
    });
});