<?php

declare(strict_types=1);

namespace Domain\Command\Invitation;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Delete
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
