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
use Domain\Repository\Users;

final class JoinHandler
{
    public function __construct(
        private readonly Users $users,
        private readonly Invitations $invitations,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Join $command): Station
    {
        if (!$user = $this->users->find($command->getUserIdentifier())) {
            throw new ObjectNotFoundException('User', $command->userId);
        }

        if (!$invitation = $this->invitations->findByToken($command->invitationToken)) {
            throw new ObjectNotFoundException('Invitation', $command->invitationToken);
        }

        $targetStation = $invitation->getStation();

        if ($targetStation->hasUser($user)) {
            throw new UserAlreadyJoinedException($targetStation, $user);
        }

        $user->joinGroup($targetStation);

        $this->eventLog->record(new Event\NewMember($targetStation, $user));

        return $targetStation;
    }
}
