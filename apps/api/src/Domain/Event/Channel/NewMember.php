<?php

namespace Domain\Event\Channel;

use Domain\Event;
use Domain\Model\Channel;
use Domain\Model\User;

final class NewMember implements Event
{
    public function __construct(public readonly Channel $channel, public readonly User $user)
    {
    }
}
