<?php

namespace Domain\Handler\Station;

use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Repository\Stations;

final class AllHandler implements Handler
{
    public function __construct(private Stations $stations)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\All;
    }

    /**
     * @return iterable<Station>
     */
    public function __invoke(Message\All $message): iterable
    {
        return $this->stations->findAll();
    }
}
