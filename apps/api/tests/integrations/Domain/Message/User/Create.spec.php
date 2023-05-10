<?php

declare(strict_types=1);

use Domain\Message\User\Create;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Create::class, function () {
    it ('holds required values', function () {
        $message = new Create(
            firstname: 'Chuck',
            lastname: 'Norris',
            email: 'chuck@gmail.com',
            password: 'helloworld@123',
            isAdmin: false
        );

        expect($message->getFirstname())->toBe('Chuck');
        expect($message->getLastname())->toBe('Norris');
        expect($message->getEmail())->toBe('chuck@gmail.com');
        expect($message->getPassword())->toBe('helloworld@123');
        expect($message->isAdmin())->toBeFalsy();
    });

    it ('validates it\'s values', function () {
        $instantiation = static fn () =>
            new Create(
                firstname: '',
                lastname: '',
                email: '',
                password: 'hello',
                isAdmin: true
            );

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('firstname'),
            PropertyAssertionFailure::at('lastname'),
            PropertyAssertionFailure::at('email'),
            PropertyAssertionFailure::at('password')
        ]);
    });
});
