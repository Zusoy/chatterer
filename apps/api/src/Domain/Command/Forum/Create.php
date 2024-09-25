<?php

declare(strict_types=1);

namespace Domain\Command\Forum;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Create
{
    public function __construct(public readonly string $name, public readonly string $stationId)
    {
        Assert::that($name, defaultPropertyPath: 'name')->notEmpty();
        Assert::that($stationId, defaultPropertyPath: 'stationId')->identifier();
    }

    public function getStationIdentifier(): Identifier
    {
        return new Identifier($this->stationId);
    }
}
