<?php

declare(strict_types=1);

namespace Domain\Message\Station;

use Domain\Message;
use Infra\Assert\Assert;

class Create implements Message
{
    public function __construct(private string $name, private ?string $description)
    {
        Assert::lazy()
            ->that($name, propertyPath: 'name')->notEmpty()
            ->that($description, propertyPath: 'description')->nullOr()->notEmpty()
            ->verifyNow()
        ;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
