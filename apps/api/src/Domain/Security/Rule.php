<?php

declare(strict_types=1);

namespace Domain\Security;

use Domain\Model\User;

interface Rule
{
    /**
     * @return Operation[]
     */
    public function getOperations(): array;

    public function allows(User $user, Operation $operation, mixed $context = null): bool;
}
