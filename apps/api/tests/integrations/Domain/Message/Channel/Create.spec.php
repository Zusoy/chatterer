<?php

use Domain\Message\Channel\Create;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Create::class, function () {
    it ('holds required values', function () {
        $message = new Create('46d788c5-f351-47d7-930e-860d7badd7a9', 'My Channel', null);

        expect((string) $message->getStationId())->toBe('46d788c5-f351-47d7-930e-860d7badd7a9');
        expect($message->getName())->toBe('My Channel');
        expect($message->getDescription())->toBeNull();
    });

    it ('holds optionals values', function () {
        $message = new Create('46d788c5-f351-47d7-930e-860d7badd7a9', 'My Channel', 'my channel desc');

        expect($message->getName())->toBe('My Channel');
        expect($message->getDescription())->toBe('my channel desc');
    });

    it ('validates it\'s values', function () {
        $instantiation = function () {
            new Create(
                '',
                '',
                ''
            );
        };

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('stationId'),
            PropertyAssertionFailure::at('name'),
            PropertyAssertionFailure::at('description')
        ]);
    });
});
