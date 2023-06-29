<?php

declare(strict_types=1);

namespace Domain\Command\Station;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Join
{
    public function __construct(
        public readonly string $userId,
        public readonly string $invitationToken
    ) {
        Assert::lazy()
            ->that($userId, propertyPath: 'userId')->identifier()
            ->that($invitationToken, propertyPath: 'invitationToken')->notEmpty()
            ->verifyNow();
    }

    public function getUserIdentifier(): Identifier
    {
        return new Identifier($this->userId);
    }
}
