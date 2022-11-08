<?php

use Domain\Message\Message\Create;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Create::class, function () {
    it ('holds required values', function () {
        $message = new Create(
            authorId: '9ad98703-ce38-44a1-859c-f82404e181e4',
            channelId: '46d788c5-f351-47d7-930e-860d7badd7a9',
            content: 'Hello world !'
        );

        expect((string) $message->getAuthorId())->toBe('9ad98703-ce38-44a1-859c-f82404e181e4');
        expect((string) $message->getChannelId())->toBe('46d788c5-f351-47d7-930e-860d7badd7a9');
        expect($message->getContent())->toBe('Hello world !');
    });

    it ('validates it\'s values', function () {
        $instantiation = static fn () =>
            new Create(
                authorId: '',
                channelId: '',
                content: '',
            );

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('authorId'),
            PropertyAssertionFailure::at('channelId'),
            PropertyAssertionFailure::at('content')
        ]);
    });
});
