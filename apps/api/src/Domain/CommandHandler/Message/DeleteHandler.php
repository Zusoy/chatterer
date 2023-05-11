<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Message;

use Application\EventLog;
use Domain\Command\Message as Command;
use Domain\Event\Message as Event;
use Domain\Exception\ObjectNotFoundException;
use Domain\Repository\Messages;

final class DeleteHandler
{
    public function __construct(
        private readonly Messages $messages,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Delete $command): void
    {
        if (!$messageToDelete = $this->messages->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Message', $command->id);
        }

        $this->messages->remove($messageToDelete);
        $this->eventLog->record(new Event\Deleted($messageToDelete));
    }
}
