<?php

declare(strict_types=1);

namespace Domain\Command\Channel;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class All
{
    public function __construct(public readonly string $stationId)
    {
        Assert::that($stationId, defaultPropertyPath: 'stationId')->identifier();
    }

    public function getStationId(): Identifier
    {
        return new Identifier($this->stationId);
    }
}
