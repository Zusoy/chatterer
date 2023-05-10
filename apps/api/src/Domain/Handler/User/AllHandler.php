<?php

declare(strict_types=1);

namespace Domain\Handler\User;

use Domain\Handler;
use Domain\Message\User as Message;
use Domain\Model\User;
use Domain\Repository\Users;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class AllHandler implements Handler
{
    public function __construct(private Users $users, private AccessControl $accessControl)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\All;
    }

    /**
     * @return iterable<User>
     */
    public function __invoke(Message\All $message): iterable
    {
        $this->accessControl->requires(Operation::USER_LIST);

        return $this->users->findAll();
    }
}
