<?php

declare(strict_types=1);

namespace Domain\Event\Invitation;

use Domain\Event;
use Domain\Model\Invitation;
use Domain\Model\Station;

final class Deleted implements Event
{
    public function __construct(public readonly Invitation $invitation, public readonly Station $station)
    {
    }
}
