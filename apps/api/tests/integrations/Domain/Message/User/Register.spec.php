<?php

use Domain\Message\User\Register;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Register::class, function () {
    it ('holds required values', function () {
        $message = new Register(
            firstname: 'Hello',
            lastname: 'World',
            email: 'hello.world@gmail.com',
            password: 'HelloWorld@123'
        );

        expect($message->getFirstname())->toBe('Hello');
        expect($message->getLastname())->toBe('World');
        expect($message->getEmail())->toBe('hello.world@gmail.com');
        expect($message->getPassword())->toBe('HelloWorld@123');
    });

    it ('validates it\'s values', function () {
        $instantiation = function () {
            new Register(
                firstname: '',
                lastname: '',
                email: '',
                password: ''
            );
        };

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('firstname'),
            PropertyAssertionFailure::at('lastname'),
            PropertyAssertionFailure::at('email'),
            PropertyAssertionFailure::at('password')
        ]);
    });
});
