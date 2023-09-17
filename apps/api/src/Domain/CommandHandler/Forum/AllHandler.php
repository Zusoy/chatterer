<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Forum;

use Domain\Command\Forum as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Forum\Forum;
use Domain\Repository\Forums;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class AllHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly Forums $forums,
        private readonly AccessControl $accessControl
    ) {
    }

    /**
     * @return iterable<Forum>
     */
    public function __invoke(Command\All $command): iterable
    {
        if (!$station = $this->stations->find($command->getStationIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->stationId);
        }

        $this->accessControl->requires(Operation::LIST_STATION_FORUMS, ['station' => $station]);

        return $this->forums->findAll($station);
    }
}
