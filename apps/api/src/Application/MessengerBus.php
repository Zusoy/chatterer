<?php

declare(strict_types=1);

namespace Application;

use Domain\Bus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class MessengerBus implements Bus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(object $message): mixed
    {
        try {
            return $this->handle($message);
        } catch (HandlerFailedException $error) {
            $previousError = $error->getPrevious();
            throw $previousError ?: $error;
        }
    }
}
