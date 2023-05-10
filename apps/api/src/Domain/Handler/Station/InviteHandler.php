<?php

declare(strict_types=1);

namespace Domain\Handler\Station;

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\Invitation;
use Domain\Repository\Invitations;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class InviteHandler implements Handler
{
    public function __construct(
        private AccessControl $accessControl,
        private Stations $stations,
        private Invitations $invitations
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Invite;
    }

    public function __invoke(Message\Invite $message): Invitation
    {
        if (!$station = $this->stations->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Station', (string) $message->getIdentifier());
        }

        $this->accessControl->requires(Operation::INVITE_STATION, ['station' => $station]);

        if (null !== $this->invitations->findByStation($station)) {
            throw new ObjectAlreadyExistsException('Invitation', (string) $station->getIdentifier());
        }

        $invitation = new Invitation($station);
        $this->invitations->add($invitation);

        return $invitation;
    }
}
