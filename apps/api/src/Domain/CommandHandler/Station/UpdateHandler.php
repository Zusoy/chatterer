<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Station;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class UpdateHandler
{
    public function __construct(
        private readonly AccessControl $accessControl,
        private readonly Stations $stations
    ) {
    }

    public function __invoke(Command\Update $command): Station
    {
        if (!$station = $this->stations->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->id);
        }

        if (null !== $this->stations->findByName($command->name)) {
            throw new ObjectAlreadyExistsException('Station', $command->name);
        }

        $this->accessControl->requires(Operation::UPDATE_STATION);

        $station->setName($command->name);
        $station->setDescription($command->description);

        return $station;
    }
}
