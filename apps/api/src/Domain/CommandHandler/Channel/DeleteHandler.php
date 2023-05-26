<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Channel;

use Domain\Command\Channel as Command;
use Domain\Event\Channel as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Repository\Channels;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class DeleteHandler
{
    public function __construct(
        private readonly AccessControl $accessControl,
        private readonly Channels $channels,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Delete $command): void
    {
        if (!$channel = $this->channels->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Channel', (string) $command->getIdentifier());
        }

        $this->accessControl->requires(Operation::DELETE_CHANNEL);

        $this->channels->remove($channel);
        $this->eventLog->record(new Event\Deleted($channel));
    }
}
