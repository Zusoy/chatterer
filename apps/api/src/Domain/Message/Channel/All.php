<?php

declare(strict_types=1);

namespace Domain\Message\Channel;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class All implements Message
{
    public function __construct(private string $stationId)
    {
        Assert::that($stationId, defaultPropertyPath: 'stationId')->identifier();
    }

    public function getStationId(): Identifier
    {
        return new Identifier($this->stationId);
    }
}
