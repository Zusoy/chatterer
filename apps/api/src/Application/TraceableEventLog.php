<?php

declare(strict_types=1);

namespace Application;

use Domain\Event;
use Psr\EventDispatcher\EventDispatcherInterface;

final class TraceableEventLog implements \Domain\EventLog
{
    /**
     * @var Event[]
     */
    private array $sentEvents = [];

    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function record(Event $event): void
    {
        $this->dispatcher->dispatch($event);

        $this->sentEvents[] = $event;
    }

    /**
     * @return Event[]
     */
    public function getSentEvents(): array
    {
        return $this->sentEvents;
    }

    public function clean(): void
    {
        $this->sentEvents = [];
    }
}
