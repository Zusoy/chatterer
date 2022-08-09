<?php

namespace Domain\Message\Station;

use Assert\Assert;
use Domain\Message;

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
