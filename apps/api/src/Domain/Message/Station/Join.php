<?php

declare(strict_types=1);

namespace Domain\Message\Station;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class Join implements Message
{
    public function __construct(
        private string $stationId,
        private string $userId,
        private string $token,
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

    public function getToken(): string
    {
        return $this->token;
    }
}
