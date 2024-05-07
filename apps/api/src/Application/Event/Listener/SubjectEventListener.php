<?php

declare(strict_types=1);

namespace Application\Event\Listener;

use Domain\Event\Subject as Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SubjectEventListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event\Created::class => ['onSubjectCreated']
        ];
    }

    public function onSubjectCreated(Event\Created $event): void
    {
    }
}
