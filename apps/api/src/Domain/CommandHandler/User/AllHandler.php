<?php

declare(strict_types=1);

namespace Domain\CommandHandler\User;

use Domain\Command\User as Command;
use Domain\Model\User;
use Domain\Repository\Users;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class AllHandler
{
    public function __construct(
        private readonly Users $users,
        private readonly AccessControl $accessControl
    ) {
    }

    /**
     * @return iterable<User>
     */
    public function __invoke(Command\All $command): iterable
    {
        $this->accessControl->requires(Operation::USER_LIST);

        return $this->users->findAll();
    }
}
