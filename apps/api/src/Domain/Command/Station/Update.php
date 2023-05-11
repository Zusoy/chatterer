<?php

declare(strict_types=1);

namespace Domain\Command\Station;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Update
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description
    ) {
        Assert::lazy()
            ->that($id, propertyPath: 'id')->identifier()
            ->that($name, propertyPath: 'name')->notEmpty()
            ->that($description, 'description')->nullOr()->notEmpty()
            ->verifyNow();
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
    }
}
