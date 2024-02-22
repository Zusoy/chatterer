<?php

declare(strict_types=1);

namespace Application\Event\Listener;

use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use Domain\Event\Message as Event;
use Domain\Search\Indexer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class MessageEventListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onMessageCreated'],
            Event\Deleted::class => ['onMessageDeleted']
        ];
    }

    public function __construct(private readonly Hub $hub, private readonly Indexer $indexer)
    {
    }

    public function onMessageCreated(Event\Created $event): void
    {
        $this->hub->push(Push\Message::insert($event->message));
        $this->indexer->upsert($event->message);
    }

    public function onMessageDeleted(Event\Deleted $event): void
    {
        $this->hub->push(Push\Message::delete($event->message));
        $this->indexer->remove($event->message);
    }
}
