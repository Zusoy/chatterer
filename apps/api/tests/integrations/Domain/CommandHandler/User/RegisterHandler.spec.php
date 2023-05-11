<?php

declare(strict_types=1);

use Domain\Command\User\Register;
use Domain\CommandHandler\User\RegisterHandler;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Model\User;
use Domain\Repository\Users;

describe(RegisterHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('users', fn () => $this->container->get(Users::class));

    it ('registers new user in database', function () {
        $command = new Register(
            firstname: 'Arthur',
            lastname: 'Pendragon',
            email: 'arthur@king.com',
            password: 'Helloworld@123'
        );

        $this->bus->execute($command);

        /** @var User */
        $registeredUser = $this->users->findByEmail('arthur@king.com');

        expect($registeredUser === null)->toBeFalsy();
        expect($registeredUser->getFirstname())->toBe('Arthur');
        expect($registeredUser->getLastname())->toBe('Pendragon');
        expect($registeredUser->getEmail())->toBe('arthur@king.com');
        expect($registeredUser->getRoles())->toBe([ 'ROLE_USER' ]);
    });

    it ('throws if user already exists in database', function () {
        $user = new User(
            firstname: 'Arthur',
            lastname: 'Pendragon',
            email: 'arthur@king.com',
            password: 'HelloWorld@123'
        );

        $this->em->persist($user);
        $this->em->flush();

        $command = new Register(
            firstname: 'Arthur',
            lastname: 'Pendragon',
            email: 'arthur@king.com',
            password: 'HelloWorld@345'
        );

        expect(fn () => $this->bus->execute($command))
            ->toThrow(new ObjectAlreadyExistsException('User', 'arthur@king.com'));
    });
});
