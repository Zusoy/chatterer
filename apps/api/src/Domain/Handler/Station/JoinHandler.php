<?php

namespace Domain\Handler\Station;

use Domain\Event\Station as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\UserAlreadyJoinedException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\Station;
use Domain\Repository\Invitations;
use Domain\Repository\Stations;
use Domain\Repository\Users;

final class JoinHandler implements Handler
{
    public function __construct(
        private Stations $stations,
        private Users $users,
        private Invitations $invitations,
        private EventLog $eventLog
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Join;
    }

    public function __invoke(Message\Join $message): Station
    {
        if (!$station = $this->stations->find($message->getStationIdentifier())) {
            throw new ObjectNotFoundException('Station', $message->getStationIdentifier());
        }

        if (!$user = $this->users->find($message->getUserIdentifier())) {
            throw new ObjectNotFoundException('User', $message->getUserIdentifier());
        }

        if (!$invitation = $this->invitations->findByToken($message->getToken(), $station)) {
            throw new ObjectNotFoundException('Invitation', $message->getToken());
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
