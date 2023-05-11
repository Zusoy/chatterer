<?php

declare(strict_types=1);

namespace Domain\Command\Station;

use Infra\Assert\Assert;

final class Create
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description
    ) {
        Assert::lazy()
            ->that($name, propertyPath: 'name')->notEmpty()
            ->that($description, propertyPath: 'description')->nullOr()->notEmpty()
            ->verifyNow();
    }
}
