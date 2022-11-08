<?php

use Domain\Message\Channel\Create;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Create::class, function () {
    it ('holds required values', function () {
        $message = new Create(
            stationId: '46d788c5-f351-47d7-930e-860d7badd7a9',
            name: 'My Channel',
            description: null
        );

        expect((string) $message->getStationId())->toBe('46d788c5-f351-47d7-930e-860d7badd7a9');
        expect($message->getName())->toBe('My Channel');
        expect($message->getDescription())->toBeNull();
    });

    it ('holds optionals values', function () {
        $message = new Create(
            stationId: '46d788c5-f351-47d7-930e-860d7badd7a9',
            name: 'My Channel',
            description: 'my channel desc'
        );

        expect($message->getName())->toBe('My Channel');
        expect($message->getDescription())->toBe('my channel desc');
    });

    it ('validates it\'s values', function () {
        $instantiation = static fn () =>
            new Create(
                stationId: '',
                name: '',
                description: ''
            );

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('stationId'),
            PropertyAssertionFailure::at('name'),
            PropertyAssertionFailure::at('description')
        ]);
    });
});
