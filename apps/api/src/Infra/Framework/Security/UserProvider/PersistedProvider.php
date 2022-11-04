<?php

namespace Infra\Framework\Security\UserProvider;

use Domain\Model\User;
use Domain\Repository\Users;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class PersistedProvider implements UserProviderInterface
{
    public function __construct(private Users $users)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByIdentifier(string $identifier): User
    {
        $user = $this->users->findByEmail($identifier);

        if (null === $user) {
            $error = new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
            $error->setUserIdentifier($identifier);
            throw $error;
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user): User
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }
}
