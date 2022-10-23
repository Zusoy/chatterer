<?php

namespace Domain\Handler\Message;

use Application\EventLog;
use Domain\Event\Message as Event;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Message as Message;
use Domain\Repository\Messages;

final class DeleteHandler implements Handler
{
    public function __construct(private Messages $messages, private EventLog $eventLog)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Delete;
    }

    public function __invoke(Message\Delete $message): void
    {
        if (!$messageToDelete = $this->messages->find($message->getId())) {
            throw new ObjectNotFoundException('Message', $message->getId());
        }

        $this->messages->remove($messageToDelete);
        $this->eventLog->record(new Event\Deleted($messageToDelete));
    }
}
