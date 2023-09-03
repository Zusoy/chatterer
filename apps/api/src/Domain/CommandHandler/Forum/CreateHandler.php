<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Forum;

use Domain\Command\Forum as Command;
use Domain\Event\Forum as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Forum\Forum;
use Domain\Repository\Forums;
use Domain\Repository\Stations;

final class CreateHandler
{
    public function __construct(
        private readonly Forums $forums,
        private readonly Stations $stations,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Create $command): Forum
    {
        if (!$station = $this->stations->find($command->getStationIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->stationId);
        }

        $forum = new Forum(
            name: $command->name,
            station: $station
        );

        $this->forums->add($forum);
        $this->eventLog->record(new Event\Created($forum));

        return $forum;
    }
}
