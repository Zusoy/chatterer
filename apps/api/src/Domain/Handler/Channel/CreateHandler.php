<?php

declare(strict_types=1);

namespace Domain\Handler\Channel;

use Domain\Event\Channel as Event;
use Domain\EventLog;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Model\Channel;
use Domain\Repository\Channels;
use Domain\Repository\Stations;

final class CreateHandler implements Handler
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
        return $message instanceof Message\Create;
    }

    public function __invoke(Message\Create $message): Channel
    {
        if (!$station = $this->stations->find($message->getStationId())) {
            throw new ObjectNotFoundException('Station', (string) $message->getStationId());
        }

        if (null !== $this->channels->findByName($station->getIdentifier(), $message->getName())) {
            throw new ObjectAlreadyExistsException('Channel', $message->getName());
        }

        $channel = new Channel(
            $station,
            $message->getName(),
            $message->getDescription()
        );

        $this->channels->add($channel);
        $this->eventLog->record(new Event\Created($channel));

        return $channel;
    }
}
