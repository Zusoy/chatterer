<?php

declare(strict_types=1);

namespace Domain\Handler\User;

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Handler;
use Domain\Message\User as Message;
use Domain\Model\User;
use Domain\Model\User\Role;
use Domain\Repository\Users;
use Domain\Security\AccessControl;
use Domain\Security\Operation;
use Domain\Security\PasswordHasher;

final class CreateHandler implements Handler
{
    public function __construct(
        private AccessControl $accessControl,
        private Users $users,
        private PasswordHasher $hasher
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Create;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(Message\Create $message): User
    {
        $this->accessControl->requires(Operation::USER_CREATE);

        if (null !== $this->users->findByEmail($message->getEmail())) {
            throw new ObjectAlreadyExistsException('User', $message->getEmail());
        }

        $user = new User(
            firstname: $message->getFirstname(),
            lastname: $message->getLastname(),
            email: $message->getEmail(),
            password: 'temp'
        );

        $user->setPassword(
            $this->hasher->hash($user, $message->getPassword())
        );

        if ($message->isAdmin()) {
            $user->setRole(Role::ADMIN);
        }

        $this->users->add($user);

        return $user;
    }
}
