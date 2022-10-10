<?php

namespace Domain\Handler\Channel;

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Model\Channel;
use Domain\Repository\Stations;

final class AllHandler implements Handler
{
    public function __construct(private Stations $stations)
    {
    }

    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\All;
    }

    /**
     * @return iterable<Channel>
     */
    public function __invoke(Message\All $message): iterable
    {
        if (!$station = $this->stations->find($message->getStationId())) {
            throw new ObjectNotFoundException('Station', $message->getStationId());
        }

        return $station->getChannels();
    }
}
