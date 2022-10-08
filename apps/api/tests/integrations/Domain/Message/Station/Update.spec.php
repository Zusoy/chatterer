<?php

use Domain\Message\Station\Update;
use Domain\Identity\Identifier;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Update::class, function() {
    it ('holds required values', function () {
        $identifier = Identifier::generate();
        $message = new Update($identifier, 'My Station', null);

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
        expect($message->getName())->toBe('My Station');
        expect($message->getDescription())->toBeNull();
    });

    it ('holds optionals values', function () {
        $identifier = Identifier::generate();
        $message = new Update($identifier, 'My Station', 'New description');

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
        expect($message->getName())->toBe('My Station');
        expect($message->getDescription())->toBe('New description');
    });

    it ('validated it\'s values', function () {
        $instantiation = function () {
            new Update(
                '',
                '',
                ''
            );
        };

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('id'),
            PropertyAssertionFailure::at('name'),
            PropertyAssertionFailure::at('description')
        ]);
    });
});
