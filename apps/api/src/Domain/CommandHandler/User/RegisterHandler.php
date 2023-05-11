<?php

declare(strict_types=1);

namespace Domain\CommandHandler\User;

use Domain\Command\User as Command;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Model\User;
use Domain\Repository\Users;
use Domain\Security\PasswordHasher;

final class RegisterHandler
{
    public function __construct(
        private readonly Users $users,
        private readonly PasswordHasher $hasher
    ) {
    }

    public function __invoke(Command\Register $command): User
    {
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

        $this->users->add($user);

        return $user;
    }
}
