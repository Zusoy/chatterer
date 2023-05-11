<?php

declare(strict_types=1);

namespace Domain\Command\Channel;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Create
{
    public function __construct(
        public readonly string $stationId,
        public readonly string $name,
        public readonly ?string $description
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
}
