<?php

declare(strict_types=1);

use Domain\Identity\Identifier;
use Domain\Message\Station\Join;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;

describe(Join::class, function () {
    it ('holds required values', function () {
        $stationIdentifier = Identifier::generate();
        $userIdentifier = Identifier::generate();
        $message = new Join(
            stationId: (string) $stationIdentifier,
            userId: (string) $userIdentifier,
            token: 'helloWorldToken'
        );

        expect((string)$message->getStationIdentifier())->toBe((string)$stationIdentifier);
        expect((string)$message->getUserIdentifier())->toBe((string)$userIdentifier);
    });

    it ('validates it\'s values', function () {
        $instantiation = static fn () => new Join(
            stationId: 'stationID',
            userId: 'userID',
            token: ''
        );

        expect($instantiation)->toFailAssertionsAtPaths([
            PropertyAssertionFailure::at('stationId'),
            PropertyAssertionFailure::at('userId'),
            PropertyAssertionFailure::at('token')
        ]);
    });
});
