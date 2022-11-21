<?php

namespace Domain\Handler\Station;

use Domain\Event\Channel as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\Channel;
use Domain\Repository\Channels;
use Domain\Repository\Stations;

final class CreateDefaultChannelHandler implements Handler
{
    public function __construct(
        private Stations $stations,
        private Channels $channels,
        private EventLog $eventLog
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\CreateDefaultChannel;
    }

    public function __invoke(Message\CreateDefaultChannel $message): Channel
    {
        if (!$station = $this->stations->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $message->getIdentifier());
        }

        $general = Channel::general($station);

        $this->channels->add($general);
        $this->eventLog->record(new Event\Created($general));

        return $general;
    }
}
