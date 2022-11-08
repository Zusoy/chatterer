<?php

use Domain\Identity\Identifier;
use Domain\Message\Channel\Update;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Update::class, function () {
    it ('holds required values', function () {
        $identifier = Identifier::generate();
        $message = new Update(
            id: $identifier,
            name: 'My Channel',
            description: null
        );

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
        expect($message->getName())->toBe('My Channel');
        expect($message->getDescription())->toBeNull();
    });

    it ('holds optionals values', function () {
        $identifier = Identifier::generate();
        $message = new Update(
            id: $identifier,
            name: 'My Channel',
            description: 'New description'
        );

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
        expect($message->getName())->toBe('My Channel');
        expect($message->getDescription())->toBe('New description');
    });

    it ('validated it\'s values', function () {
        $instantiation = static fn () =>
            new Update(
                id: '',
                name: '',
                description: ''
            );

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('id'),
            PropertyAssertionFailure::at('name'),
            PropertyAssertionFailure::at('description')
        ]);
    });
});
