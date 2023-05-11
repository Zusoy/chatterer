<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Channel;

use Domain\Command\Channel as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Channel;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class AllHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly AccessControl $accessControl
    ) {
    }

    /**
     * @return iterable<Channel>
     */
    public function __invoke(Command\All $command): iterable
    {
        if (!$station = $this->stations->find($command->getStationId())) {
            throw new ObjectNotFoundException('Station', (string) $command->getStationId());
        }

        $this->accessControl->requires(Operation::LIST_STATION_CHANNELS, ['station' => $station]);

        return $station->getChannels();
    }
}
