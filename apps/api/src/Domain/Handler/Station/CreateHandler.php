<?php

namespace Domain\Handler\Station;

use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\Station;
use Domain\Repository\Stations;

final class CreateHandler implements Handler
{
    public function __construct(private Stations $stations)
    {
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
        $station = new Station($message->getName(), $message->getDescription());

        $this->stations->add($station);

        return $station;
    }
}