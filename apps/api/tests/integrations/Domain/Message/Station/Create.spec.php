<?php

use Domain\Message\Station\Create;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Create::class, function () {
    it ('holds required values', function () {
        $message = new Create('My Station', null);

        expect($message->getName())->toBe('My Station');
        expect($message->getDescription())->toBeNull();
    });

    it ('holds optionals values', function () {
        $message = new Create('My Station', 'my station desc');

        expect($message->getName())->toBe('My Station');
        expect($message->getDescription())->toBe('my station desc');
    });

    it ('validates it\'s values', function () {
        $instantiation = function () {
            new Create(
                '',
                ''
            );
        };

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('name'),
            PropertyAssertionFailure::at('description')
        ]);
    });
});
