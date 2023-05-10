<?php

declare(strict_types=1);

namespace Domain\Message\Channel;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class Update implements Message
{
    public function __construct(
        private string $id,
        private string $name,
        private ?string $description
    ) {
        Assert::lazy()
            ->that($id, propertyPath: 'id')->identifier()
            ->that($name, propertyPath: 'name')->notEmpty()
            ->that($description, propertyPath: 'description')->nullOr()->notEmpty()
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
