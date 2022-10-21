<?php

namespace Application\Event\Listener;

use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use Domain\Event\Message as Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class MessageEventListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onMessageCreated']
        ];
    }

    public function __construct(private Hub $hub)
    {
    }

    public function onMessageCreated(Event\Created $event): void
    {
        $this->hub->push(Push\Message::insert($event->message));
    }
}
