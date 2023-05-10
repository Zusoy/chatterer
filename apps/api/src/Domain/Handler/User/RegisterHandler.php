<?php

declare(strict_types=1);

namespace Domain\Handler\User;

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Handler;
use Domain\Message\User as Message;
use Domain\Model\User;
use Domain\Repository\Users;
use Domain\Security\PasswordHasher;

final class RegisterHandler implements Handler
{
    public function __construct(private Users $users, private PasswordHasher $hasher)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Register;
    }

    public function __invoke(Message\Register $message): User
    {
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

        $this->users->add($user);

        return $user;
    }
}
