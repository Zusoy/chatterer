<?php

declare(strict_types=1);

namespace Domain\Command\Station;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class ListUsers
{
    public function __construct(public readonly string $id)
    {
        Assert::that($id, defaultPropertyPath: 'id')->identifier();
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
    }
}
