<?php

declare(strict_types=1);

namespace Domain\Security\Rule;

use Domain\Model\User;
use Domain\Security\Operation;
use Domain\Security\Rule;

final class Channel implements Rule
{
    /**
     * {@inheritDoc}
     */
    public function getOperations(): array
    {
        return [
            Operation::CREATE_CHANNEL,
            Operation::UPDATE_CHANNEL,
            Operation::DELETE_CHANNEL,
            Operation::JOIN_CHANNEL,
            Operation::LIST_USERS_CHANNEL
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function allows(User $user, Operation $operation, mixed $context = null): bool
    {
        return match($operation) {
            Operation::JOIN_CHANNEL => $user->isInStation($context['channel']->getStation()),
            Operation::LIST_USERS_CHANNEL => $user->isInChannel($context['channel']) || $user->isAdmin(),

            default => $user->isAdmin()
        };
    }
}
