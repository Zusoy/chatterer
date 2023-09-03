<?php

declare(strict_types=1);

namespace Domain\Event\Subject;

use Domain\Event;
use Domain\Model\Forum\Subject;

final class Created implements Event
{
    public function __construct(public readonly Subject $subject)
    {
    }
}
