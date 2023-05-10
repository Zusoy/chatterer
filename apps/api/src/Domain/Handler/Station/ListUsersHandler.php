<?php

declare(strict_types=1);

namespace Domain\Handler\Station;

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\User;
use Domain\Repository\Stations;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class ListUsersHandler implements Handler
{
    public function __construct(private Stations $stations, private AccessControl $accessControl)
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
        if (!$station = $this->stations->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Station', (string) $message->getIdentifier());
        }

        $this->accessControl->requires(Operation::LIST_STATION_USERS, ['station' => $station]);

        return $station->getUsers();
    }
}
