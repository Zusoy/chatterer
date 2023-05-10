<?php

declare(strict_types=1);

use Domain\Message\Station\Update;
use Domain\Identity\Identifier;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Update::class, function() {
    it ('holds required values', function () {
        $identifier = Identifier::generate();
        $message = new Update(
            id: (string) $identifier,
            name: 'My Station',
            description: null
        );

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
        expect($message->getName())->toBe('My Station');
        expect($message->getDescription())->toBeNull();
    });

    it ('holds optionals values', function () {
        $identifier = Identifier::generate();
        $message = new Update(
            id: (string) $identifier,
            name: 'My Station',
            description: 'New description'
        );

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
        expect($message->getName())->toBe('My Station');
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
