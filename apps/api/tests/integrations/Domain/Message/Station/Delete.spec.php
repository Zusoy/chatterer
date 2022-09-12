<?php

use Domain\Message\Station\Delete;
use Domain\Identity\Identifier;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Delete::class, function () {
    it ('holds required values', function () {
        $identifier = Identifier::generate();
        $message = new Delete($identifier);

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
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
