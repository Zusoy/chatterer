<?php

namespace Application;

use Domain\Event;
use Psr\EventDispatcher\EventDispatcherInterface;

final class EventLog implements \Domain\EventLog
{
    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function record(Event $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
