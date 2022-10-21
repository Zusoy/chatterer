<?php

namespace Application\Event\Listener;

use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use Domain\Event\Channel as Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ChannelEventListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onChannelCreated'],
            Event\Deleted::class => ['onChannelDeleted']
        ];
    }

    public function __construct(private Hub $hub)
    {
    }

    public function onChannelCreated(Event\Created $event): void
    {
        $this->hub->push(Push\Channel::insert($event->channel));
    }

    public function onChannelDeleted(Event\Deleted $event): void
    {
        $this->hub->push(Push\Channel::delete($event->channel));
    }
}
