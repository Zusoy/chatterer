<?php

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Handler\User\CreateHandler;
use Domain\Message\User\Create;
use Domain\Model\User;
use Domain\Repository\Users;

describe(CreateHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('users', fn () => $this->container->get(Users::class));

    it ('creates new user in database', function () {
        $message = new Create(
            firstname: 'Chuck',
            lastname: 'Norris',
            email: 'chuck@gmail.com',
            password: 'helloworld@123',
            isAdmin: true
        );

        $this->bus->execute($message);

        /** @var User */
        $persistedUser = $this->users->findByEmail('chuck@gmail.com');

        expect($persistedUser === null)->toBeFalsy();
        expect($persistedUser->getFirstname())->toBe('Chuck');
        expect($persistedUser->getLastname())->toBe('Norris');
        expect($persistedUser->getEmail())->toBe('chuck@gmail.com');
        expect($persistedUser->isAdmin())->toBeTruthy();
    });

    it ('throws if user already exists in database', function () {
        $user = new User(
            firstname: 'Chuck',
            lastname: 'Norris',
            email: 'chuck@gmail.com',
            password: 'helloworld@123'
        );

        $this->em->persist($user);
        $this->em->flush();

        expect(fn () => $this->bus->execute(new Create(
            firstname: 'Chuck',
            lastname: 'Norris',
            email: 'chuck@gmail.com',
            password: 'helloworld@123',
            isAdmin: true
        )))->toThrow(new ObjectAlreadyExistsException('User', 'chuck@gmail.com'));
    });
});
