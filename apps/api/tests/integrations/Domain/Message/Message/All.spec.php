<?php

use Domain\Message\Message\All;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(All::class, function () {
    it ('holds required values', function () {
        $message = new All(
            channelId: '46d788c5-f351-47d7-930e-860d7badd7a9'
        );

        expect((string) $message->getChannelId())->toBe('46d788c5-f351-47d7-930e-860d7badd7a9');
    });

    it ('validates it\'s values', function () {
        $instantiation = static fn () =>
            new All(
                channelId: '15'
            );

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('channelId')
        ]);
    });
});
