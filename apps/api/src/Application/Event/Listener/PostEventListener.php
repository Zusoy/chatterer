<?php

declare(strict_types=1);

namespace Application\Event\Listener;

use Domain\Event\Post as Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PostEventListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onPostCreated'],
        ];
    }

    public function onPostCreated(Event\Created $event): void
    {
    }
}
