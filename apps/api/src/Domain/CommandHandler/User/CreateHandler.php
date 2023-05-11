<?php

declare(strict_types=1);

namespace Domain\CommandHandler\User;

use Domain\Command\User as Command;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Model\User;
use Domain\Model\User\Role;
use Domain\Repository\Users;
use Domain\Security\AccessControl;
use Domain\Security\Operation;
use Domain\Security\PasswordHasher;

final class CreateHandler
{
    public function __construct(
        private readonly AccessControl $accessControl,
        private readonly Users $users,
        private readonly PasswordHasher $hasher
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(Command\Create $command): User
    {
        $this->accessControl->requires(Operation::USER_CREATE);

        if (null !== $this->users->findByEmail($command->email)) {
            throw new ObjectAlreadyExistsException('User', $command->email);
        }

        $user = new User(
            firstname: $command->firstname,
            lastname: $command->lastname,
            email: $command->email,
            password: 'temp'
        );

        $user->setPassword(
            $this->hasher->hash($user, $command->password)
        );

        if ($command->isAdmin) {
            $user->setRole(Role::ADMIN);
        }

        $this->users->add($user);

        return $user;
    }
}
