<?php

declare(strict_types=1);

namespace Domain\Command\Station;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class AddUser
{
    public function __construct(
        public readonly string $stationId,
        public readonly string $userId,
        public readonly string $token,
    ) {
        Assert::lazy()
            ->that($stationId, propertyPath: 'stationId')
                ->identifier()
            ->that($userId, propertyPath: 'userId')
                ->identifier()
            ->that($token, propertyPath: 'token')
                ->notEmpty()
            ->verifyNow();
    }

    public function getStationIdentifier(): Identifier
    {
        return new Identifier($this->stationId);
    }

    public function getUserIdentifier(): Identifier
    {
        return new Identifier($this->userId);
    }
}
