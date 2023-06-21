<?php

declare(strict_types=1);

namespace Domain\Command\Station;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class All
{
    public function __construct(public readonly string $userId)
    {
        Assert::that($userId)->identifier();
    }

    public function getUserIdentifier(): Identifier
    {
        return new Identifier($this->userId);
    }
}
