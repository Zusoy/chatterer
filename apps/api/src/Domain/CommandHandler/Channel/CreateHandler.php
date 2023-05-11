<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Channel;

use Domain\Command\Channel as Command;
use Domain\Event\Channel as Event;
use Domain\EventLog;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Channel;
use Domain\Repository\Channels;
use Domain\Repository\Stations;

final class CreateHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly Channels $channels,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Create $command): Channel
    {
        if (!$station = $this->stations->find($command->getStationId())) {
            throw new ObjectNotFoundException('Station', (string) $command->getStationId());
        }

        if (null !== $this->channels->findByName($station->getIdentifier(), $command->name)) {
            throw new ObjectAlreadyExistsException('Channel', $command->name);
        }

        $channel = new Channel(
            $station,
            $command->name,
            $command->description
        );

        $this->channels->add($channel);
        $this->eventLog->record(new Event\Created($channel));

        return $channel;
    }
}
