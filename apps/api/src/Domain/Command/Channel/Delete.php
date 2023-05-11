<?php

declare(strict_types=1);

namespace Domain\Command\Channel;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Delete
{
    public function __construct(public readonly string $id)
    {
        Assert::lazy()
            ->that($id, propertyPath: 'id')->identifier()
            ->verifyNow();
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
    }
}
