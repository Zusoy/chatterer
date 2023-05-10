<?php

declare(strict_types=1);

namespace Application\Security;

use Domain\Model\User;
use RuntimeException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final class UserProvider implements \Domain\Security\UserProvider
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getCurent(): ?User
    {
        if (!$token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!$user = $token->getUser()) {
            return null;
        }

        if (!$user instanceof User) {
            throw new RuntimeException('Current user is not valid.');
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrent(User $user): void
    {
        $this->tokenStorage->setToken(
            new UsernamePasswordToken(
                user: $user,
                firewallName: 'api',
                roles: $user->getRoles()
            )
        );
    }
}
