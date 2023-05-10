<?php

declare(strict_types=1);

namespace Domain\Event\Station;

use Domain\Event;
use Domain\Model\Station;

final class Created implements Event
{
    public function __construct(public readonly Station $station)
    {
    }
}
