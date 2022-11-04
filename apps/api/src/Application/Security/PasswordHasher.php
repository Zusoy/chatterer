<?php

namespace Application\Security;

use Domain\Model\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class PasswordHasher implements \Domain\Security\PasswordHasher
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function hash(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }
}
