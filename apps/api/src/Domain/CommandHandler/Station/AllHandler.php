<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Station;
use Domain\Repository\Stations;
use Domain\Repository\Users;

final class AllHandler
{
    public function __construct(private readonly Stations $stations, public readonly Users $users)
    {
    }

    /**
     * @return iterable<Station>
     */
    public function __invoke(Command\All $command): iterable
    {
        if (!$user = $this->users->find($command->getUserIdentifier())) {
            throw new ObjectNotFoundException('User', $command->userId);
        }

        return $user->isAdmin()
            ? $this->stations->findAll()
            : $user->getStations();
    }
}
