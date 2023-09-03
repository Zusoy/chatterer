<?php

declare(strict_types=1);

namespace Domain\Event\Forum;

use Domain\Event;
use Domain\Model\Forum\Forum;

final class Created implements Event
{
    public function __construct(public readonly Forum $forum)
    {
    }
}
