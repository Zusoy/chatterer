<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Station;
use Domain\Repository\Stations;

final class GetHandler
{
    public function __construct(private readonly Stations $stations)
    {
    }

    public function __invoke(Command\Get $command): Station
    {
        if (!$station = $this->stations->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->id);
        }

        return $station;
    }
}
