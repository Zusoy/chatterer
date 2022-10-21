<?php

namespace Domain\Event\Message;

use Domain\Event;
use Domain\Model\Message;

final class Created implements Event
{
    public function __construct(public readonly Message $message)
    {
    }
}
