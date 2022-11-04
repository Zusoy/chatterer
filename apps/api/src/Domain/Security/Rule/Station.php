<?php

namespace Domain\Security\Rule;

use Domain\Model\User;
use Domain\Security\Operation;
use Domain\Security\Rule;

final class Station implements Rule
{
    /**
     * {@inheritDoc}
     */
    public function getOperations(): array
    {
        return [
            Operation::CREATE_STATION,
            Operation::UPDATE_STATION,
            Operation::DELETE_STATION
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function allows(User $user, Operation $operation, mixed $context = null): bool
    {
        return match($operation) {
            Operation::CREATE_STATION => $user->isAdmin(),

            default => $user->isAdmin()
        };
    }
}
