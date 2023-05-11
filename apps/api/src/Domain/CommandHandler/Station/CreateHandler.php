<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Event\Station as Event;
use Domain\EventLog;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Model\Station;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class CreateHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly EventLog $eventLog,
        private readonly AccessControl $accessControl
    ) {
    }

    public function __invoke(Command\Create $command): Station
    {
        if (null !== $this->stations->findByName($command->name)) {
            throw new ObjectAlreadyExistsException('Station', $command->name);
        }

        $this->accessControl->requires(Operation::CREATE_STATION);

        $station = new Station($command->name, $command->description);

        $this->stations->add($station);
        $this->eventLog->record(new Event\Created($station));

        return $station;
    }
}
