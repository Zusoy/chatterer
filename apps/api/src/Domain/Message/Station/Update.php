<?php

namespace Domain\Message\Station;

use Assert\Assert;
use Domain\Message;
use Domain\Model\Identity\Identifier;

class Update implements Message
{
    public function __construct(
        private string $id,
        private string $name,
        private ?string $description
    ) {
        Assert::lazy()
            ->that($id, propertyPath: 'id')->notEmpty()->regex(sprintf('/%s/', Identifier::PATTERN))
            ->that($name, propertyPath: 'name')->notEmpty()
            ->that($description, 'description')->nullOr()->notEmpty()
            ->verifyNow()
        ;
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
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
