<?php

declare(strict_types=1);

namespace Application\Event\Listener;

use Domain\Event\Forum as Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ForumEventListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onForumCreated']
        ];
    }

    public function onForumCreated(Event\Created $event): void
    {
    }
}
