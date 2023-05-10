<?php

declare(strict_types=1);

namespace Domain\Handler\Channel;

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Model\Channel;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class AllHandler implements Handler
{
    public function __construct(private Stations $stations, private AccessControl $accessControl)
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
            throw new ObjectNotFoundException('Station', (string) $message->getStationId());
        }

        $this->accessControl->requires(Operation::LIST_STATION_CHANNELS, ['station' => $station]);

        return $station->getChannels();
    }
}
