<?php

declare(strict_types=1);

namespace Application\Event\Listener;

use Application\Synchronization\Hub;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class SynchronizationListener implements EventSubscriberInterface
{
    public function __construct(private Hub $hub)
    {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::FINISH_REQUEST => 'synchronize',
            KernelEvents::TERMINATE => 'synchronize'
        ];
    }

    public function synchronize(): void
    {
        $this->hub->send();
    }
}
