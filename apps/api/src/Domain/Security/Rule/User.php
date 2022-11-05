<?php

namespace Domain\Security\Rule;

use Domain\Model\User as ModelUser;
use Domain\Security\Operation;
use Domain\Security\Rule;

final class User implements Rule
{
    /**
     * {@inheritDoc}
     */
    public function getOperations(): array
    {
        return [
            Operation::USER_CREATE,
            Operation::USER_LIST
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function allows(ModelUser $user, Operation $operation, mixed $context = null): bool
    {
        return match($operation) {
            Operation::USER_CREATE,
            Operation::USER_LIST => $user->isAdmin(),

            default => $user->isAdmin()
        };
    }
}
