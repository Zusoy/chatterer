<?php

namespace Domain\Handler\Station;

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\Station;
use Domain\Repository\Stations;

final class UpdateHandler implements Handler
{
    public function __construct(private Stations $stations)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Update;
    }

    public function __invoke(Message\Update $message): Station
    {
        if (!$station = $this->stations->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $message->getIdentifier());
        }

        $station->setName($message->getName());
        $station->setDescription($message->getDescription());

        $station->touch();

        return $station;
    }
}