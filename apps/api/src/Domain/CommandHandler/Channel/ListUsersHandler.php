<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Channel;

use Domain\Command\Channel as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\User;
use Domain\Repository\Channels;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class ListUsersHandler
{
    public function __construct(
        private readonly Channels $channels,
        private readonly AccessControl $accessControl
    ) {
    }

    /**
     * @return iterable<User>
     */
    public function __invoke(Command\ListUsers $command): iterable
    {
        if (!$channel = $this->channels->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Channel', (string) $command->getIdentifier());
        }

        $this->accessControl->requires(Operation::LIST_USERS_CHANNEL, ['channel' => $channel]);

        return $channel->getUsers();
    }
}
