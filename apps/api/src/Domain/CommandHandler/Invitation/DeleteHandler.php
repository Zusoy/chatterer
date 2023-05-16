<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Invitation;

use Domain\Command\Invitation as Command;
use Domain\Event\Invitation as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Repository\Invitations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class DeleteHandler
{
    public function __construct(
        private readonly AccessControl $accessControl,
        private readonly Invitations $invitations,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Delete $command): void
    {
        if (!$invitation = $this->invitations->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Invitation', $command->id);
        }

        $this->accessControl->requires(Operation::DELETE_INVITATION, ['station' => $invitation->getStation()]);

        $this->invitations->remove($invitation);
        $this->eventLog->record(new Event\Deleted($invitation, $invitation->getStation()));
    }
}
