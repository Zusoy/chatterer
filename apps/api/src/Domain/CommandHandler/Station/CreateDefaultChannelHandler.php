<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Event\Channel as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Channel;
use Domain\Repository\Channels;
use Domain\Repository\Stations;

final class CreateDefaultChannelHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly Channels $channels,
        private readonly EventLog $eventLog,
        private readonly string $defaultChannelName
    ) {
    }

    public function __invoke(Command\CreateDefaultChannel $command): Channel
    {
        if (!$station = $this->stations->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->id);
        }

        $general = Channel::general(station: $station, name: $this->defaultChannelName);

        $this->channels->add($general);
        $this->eventLog->record(new Event\Created($general));

        return $general;
    }
}
