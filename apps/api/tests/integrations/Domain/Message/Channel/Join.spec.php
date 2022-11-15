<?php

use Domain\Message\Channel\Join;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Join::class, function () {
    it ('holds required values', function () {
        $message = new Join(
            channelId: '46d788c5-f351-47d7-930e-860d7badd7a9',
            userId: '46d788c5-f351-930e-47d7-860d7badd7a9'
        );

        expect((string) $message->getChannelIdentifier())->toBe('46d788c5-f351-47d7-930e-860d7badd7a9');
        expect((string) $message->getUserIdentifier())->toBe('46d788c5-f351-930e-47d7-860d7badd7a9');
    });

    it ('validates it\'s values', function () {
        $instantiation = static fn () => new Join(
            channelId: '',
            userId: 'notValidId'
        );

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('channelId'),
            PropertyAssertionFailure::at('userId')
        ]);
    });
});
