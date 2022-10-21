<?php

namespace Application\Event\Listener;

use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use Domain\Event\Station as Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class StationEventListener implements EventSubscriberInterface
{
    public function __construct(private Hub $hub)
    {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onStationCreated'],
            Event\Deleted::class => ['onStationDeleted']
        ];
    }

    public function onStationCreated(Event\Created $event): void
    {
        $this->hub->push(Push\Station::insert($event->station));
    }

    public function onStationDeleted(Event\Deleted $event): void
    {
        $this->hub->push(Push\Station::delete($event->station));
    }
}
