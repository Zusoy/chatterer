<?php

use Domain\Message\Message\Create;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Create::class, function () {
    it ('holds required values', function () {
        $message = new Create(
            channelId: '46d788c5-f351-47d7-930e-860d7badd7a9',
            content: 'Hello world !'
        );

        expect((string) $message->getChannelId())->toBe('46d788c5-f351-47d7-930e-860d7badd7a9');
        expect($message->getContent())->toBe('Hello world !');
    });

    it ('validates it\'s values', function () {
        $instantiation = function () {
            new Create(
                channelId: '',
                content: '',
            );
        };

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('channelId'),
            PropertyAssertionFailure::at('content')
        ]);
    });
});
