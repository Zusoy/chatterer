<?php

declare(strict_types=1);

namespace Domain\Message\Channel;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class Create implements Message
{
    public function __construct(
        private string $stationId,
        private string $name,
        private ?string $description
    ) {
        Assert::lazy()
            ->that($stationId, propertyPath: 'stationId')->identifier()
            ->that($name, propertyPath: 'name')->notEmpty()
            ->that($description, propertyPath: 'description')->nullOr()->notEmpty()
            ->verifyNow()
        ;
    }

    public function getStationId(): Identifier
    {
        return new Identifier($this->stationId);
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
