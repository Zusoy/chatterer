<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Message;

use Application\EventLog;
use Domain\Command\Message as Command;
use Domain\Event\Message as Event;
use Domain\Exception\ObjectNotFoundException;
use Domain\Repository\Messages;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class DeleteHandler
{
    public function __construct(
        private readonly AccessControl $accessControl,
        private readonly Messages $messages,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Delete $command): void
    {
        if (!$messageToDelete = $this->messages->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Message', $command->id);
        }

        $this->accessControl->requires(Operation::DELETE_MESSAGE, ['message' => $messageToDelete]);

        $this->messages->remove($messageToDelete);
        $this->eventLog->record(new Event\Deleted($messageToDelete));
    }
}
