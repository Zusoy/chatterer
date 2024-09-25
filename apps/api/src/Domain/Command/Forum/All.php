<?php

declare(strict_types=1);

namespace Domain\Command\Forum;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class All
{
    public function __construct(public readonly string $stationId)
    {
        Assert::that($stationId, defaultPropertyPath: 'stationId')->identifier();
    }

    public function getStationIdentifier(): Identifier
    {
        return new Identifier($this->stationId);
    }
}
