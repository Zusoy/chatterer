<?php

declare(strict_types=1);

namespace Domain\Handler\Channel;

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Model\User;
use Domain\Repository\Channels;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class ListUsersHandler implements Handler
{
    public function __construct(private Channels $channels, private AccessControl $accessControl)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\ListUsers;
    }

    /**
     * @return iterable<User>
     */
    public function __invoke(Message\ListUsers $message): iterable
    {
        if (!$channel = $this->channels->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Channel', (string) $message->getIdentifier());
        }

        $this->accessControl->requires(Operation::LIST_USERS_CHANNEL, ['channel' => $channel]);

        return $channel->getUsers();
    }
}
