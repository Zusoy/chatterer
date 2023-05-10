<?php

declare(strict_types=1);

use Domain\Message\Station\Delete;
use Domain\Identity\Identifier;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Delete::class, function () {
    it ('holds required values', function () {
        $identifier = Identifier::generate();
        $message = new Delete(id: (string) $identifier);

        expect((string)$message->getIdentifier())->toBe((string)$identifier);
    });

    it ('validates it\'s values', function () {
        $instantiation = static fn () => new Delete(id: '10');

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('id')
        ]);
    });
});
