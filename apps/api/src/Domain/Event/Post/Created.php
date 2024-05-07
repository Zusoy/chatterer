<?php

declare(strict_types=1);

namespace Domain\Event\Post;

use Domain\Event;
use Domain\Model\Forum\Post;

final class Created implements Event
{
    public function __construct(public readonly Post $post)
    {
    }
}
