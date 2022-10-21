<?php

namespace Domain\Handler\Station;

use Domain\Event\Station as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Repository\Stations;

final class DeleteHandler implements Handler
{
    public function __construct(private Stations $stations, private EventLog $eventLog)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Delete;
    }

    public function __invoke(Message\Delete $message): void
    {
        if (!$station = $this->stations->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $message->getIdentifier());
        }

        $this->stations->remove($station);
        $this->eventLog->record(new Event\Deleted($station));
    }
}
