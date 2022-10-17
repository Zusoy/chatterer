<?php

use Domain\Message\Channel\Delete;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Delete::class, function () {
    it ('holds required values', function () {
        $message = new Delete('46d788c5-f351-47d7-930e-860d7badd7a9');

        expect((string) $message->getIdentifier())->toBe('46d788c5-f351-47d7-930e-860d7badd7a9');
    });

    it ('validates it\'s values', function () {
        $instantiation = function () {
            new Delete('10');
        };

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('id')
        ]);
    });
});
