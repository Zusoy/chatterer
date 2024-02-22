<?php

declare(strict_types=1);

namespace Application\Event\Listener;

use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use Domain\Bus;
use Domain\Command\Station as Command;
use Domain\Event\Station as Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class StationEventListener implements EventSubscriberInterface
{
    public function __construct(private readonly Hub $hub, private readonly Bus $bus)
    {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onStationCreated'],
            Event\Deleted::class => ['onStationDeleted'],
            Event\NewMember::class => ['onStationNewMember']
        ];
    }

    public function onStationCreated(Event\Created $event): void
    {
        $this->hub->push(Push\Station::insert($event->station));
        $this->bus->execute(new Command\CreateDefaultChannel(id: (string) $event->station->getIdentifier()));
    }

    public function onStationDeleted(Event\Deleted $event): void
    {
        $this->hub->push(Push\Station::delete($event->station));
    }

    public function onStationNewMember(Event\NewMember $event): void
    {
    }
}
