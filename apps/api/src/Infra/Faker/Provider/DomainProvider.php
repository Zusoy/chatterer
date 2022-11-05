<?php

namespace Infra\Faker\Provider;

use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Model\User\Role;
use Domain\Security\PasswordHasher;
use Faker\Generator;
use Faker\Provider\Base;

final class DomainProvider extends Base
{
    public function __construct(Generator $generator, private PasswordHasher $passwordHasher)
    {
        parent::__construct($generator);
    }

    public function user(string $email): User
    {
        $user = new User(
            firstname: $this->generator->firstName(),
            lastname: $this->generator->lastName(),
            email: $email,
            password: 'temp'
        );

        $user->setPassword(
            $this->passwordHasher->hash($user, $user->getEmail())
        );

        return $user;
    }

    public function admin(string $email): User
    {
        $user = new User(
            firstname: $this->generator->firstName(),
            lastname: $this->generator->lastName(),
            email: $email,
            password: 'temp'
        );

        $user->setPassword(
            $this->passwordHasher->hash($user, $user->getEmail())
        );

        $user->setRole(Role::ADMIN);

        return $user;
    }

    public function station(): Station
    {
        return new Station(
            name: $this->generator->unique()->company(),
            description: $this->generator->boolean(75)
                ? $this->generator->sentence(10)
                : null
        );
    }

    /**
     * @param Station[] $stations
     */
    public function channel(array $stations): Channel
    {
        /** @var Station */
        $station = $this->randomRelation($stations, nullable: false);

        $channel = new Channel(
            station: $station,
            name: $this->generator->unique()->text(maxNbChars: 8),
            description: $this->generator->boolean(75)
                ? $this->generator->sentence(10)
                : null
        );

        return $channel;
    }

    /**
     * @param User[] $users
     * @param Channel[] $channels
     */
    public function message(array $users, array $channels): Message
    {
        /** @var User */
        $author = $this->randomRelation($users, nullable: false);

        /** @var Channel */
        $channel = $this->randomRelation($channels, nullable: false);

        $message = new Message(
            author: $author,
            channel: $channel,
            content: $this->generator->text(maxNbChars: 100)
        );

        return $message;
    }

    /**
     * @template T
     *
     * @param T[] $collection
     *
     * @return ?T
     */
    private function randomRelation(array $collection, bool $nullable = false)
    {
        if (0 === count($collection)) {
            return null;
        }

        return $this->generator->boolean($nullable ? 75 : 100)
            ? $this->generator->randomElement($collection)
            : null
        ;
    }
}
