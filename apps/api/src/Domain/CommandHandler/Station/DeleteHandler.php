<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Event\Station as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Repository\Stations;

final class DeleteHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Delete $command): void
    {
        if (!$station = $this->stations->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->id);
        }

        $this->stations->remove($station);
        $this->eventLog->record(new Event\Deleted($station));
    }
}
