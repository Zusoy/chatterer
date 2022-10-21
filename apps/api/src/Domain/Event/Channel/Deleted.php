<?php

namespace Domain\Event\Channel;

use Domain\Event;
use Domain\Model\Channel;

final class Deleted implements Event
{
    public function __construct(public readonly Channel $channel)
    {
    }
}
