<?php

namespace Domain\Handler\Station;

use Domain\Event\Station as Event;
use Domain\EventLog;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\Station;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class CreateHandler implements Handler
{
    public function __construct(
        private Stations $stations,
        private EventLog $eventLog,
        private AccessControl $accessControl
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Create;
    }

    public function __invoke(Message\Create $message): Station
    {
        if (null !== $this->stations->findByName($message->getName())) {
            throw new ObjectAlreadyExistsException('Station', $message->getName());
        }

        $this->accessControl->requires(Operation::CREATE_STATION);

        $station = new Station($message->getName(), $message->getDescription());

        $this->stations->add($station);
        $this->eventLog->record(new Event\Created($station));

        return $station;
    }
}
