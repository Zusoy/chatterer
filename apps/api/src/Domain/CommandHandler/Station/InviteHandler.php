<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Invitation;
use Domain\Repository\Invitations;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class InviteHandler
{
    public function __construct(
        private readonly AccessControl $accessControl,
        private readonly Stations $stations,
        private readonly Invitations $invitations
    ) {
    }

    public function __invoke(Command\Invite $command): Invitation
    {
        if (!$station = $this->stations->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Station', $command->id);
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
