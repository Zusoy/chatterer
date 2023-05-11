<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\User;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class ListUsersHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly AccessControl $accessControl
    ) {
    }

    /**
     * @return iterable<User>
     */
    public function __invoke(Command\ListUsers $command): iterable
    {
        if (!$station = $this->stations->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->id);
        }

        $this->accessControl->requires(Operation::LIST_STATION_USERS, ['station' => $station]);

        return $station->getUsers();
    }
}
