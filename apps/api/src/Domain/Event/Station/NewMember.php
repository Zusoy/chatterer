<?php

namespace Domain\Event\Station;

use Domain\Event;
use Domain\Model\Station;
use Domain\Model\User;

final class NewMember implements Event
{
    public function __construct(public readonly Station $station, public readonly User $user)
    {
    }
}
