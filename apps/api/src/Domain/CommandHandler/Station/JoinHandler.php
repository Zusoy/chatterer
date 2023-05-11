<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Event\Station as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\UserAlreadyJoinedException;
use Domain\Model\Station;
use Domain\Repository\Invitations;
use Domain\Repository\Stations;
use Domain\Repository\Users;

final class JoinHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly Users $users,
        private readonly Invitations $invitations,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Join $command): Station
    {
        if (!$station = $this->stations->find($command->getStationIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->stationId);
        }

        if (!$user = $this->users->find($command->getUserIdentifier())) {
            throw new ObjectNotFoundException('User', $command->userId);
        }

        if (!$invitation = $this->invitations->findByToken($command->token, $station)) {
            throw new ObjectNotFoundException('Invitation', $command->token);
        }

        if ($station->has($user)) {
            throw new UserAlreadyJoinedException($station, $user);
        }

        $user->joinStation($station);
        $this->invitations->remove($invitation);

        $this->eventLog->record(new Event\NewMember($station, $user));

        return $station;
    }
}
