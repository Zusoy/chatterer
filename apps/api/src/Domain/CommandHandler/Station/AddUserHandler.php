<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Event\Station as Event;
use Domain\EventLog;
use Domain\Exception\InvalidInvitationTokenException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\UserAlreadyJoinedException;
use Domain\Model\Station;
use Domain\Repository\Invitations;
use Domain\Repository\Stations;
use Domain\Repository\Users;

final class AddUserHandler
{
    public function __construct(
        private readonly Stations $stations,
        private readonly Users $users,
        private readonly Invitations $invitations,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\AddUser $command): Station
    {
        if (!$station = $this->stations->find($command->getStationIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->stationId);
        }

        if (!$user = $this->users->find($command->getUserIdentifier())) {
            throw new ObjectNotFoundException('User', $command->userId);
        }

        if (!$stationInvitation = $this->invitations->findByStation($station)) {
            throw new ObjectNotFoundException('Invitation', $command->token);
        }

        if ($command->token !== (string) $stationInvitation->getToken()) {
            throw new InvalidInvitationTokenException($command->token);
        }

        if ($station->hasUser($user)) {
            throw new UserAlreadyJoinedException($station, $user);
        }

        $user->joinGroup($station);

        $this->eventLog->record(new Event\NewMember($station, $user));

        return $station;
    }
}
