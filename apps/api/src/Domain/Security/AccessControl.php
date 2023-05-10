<?php

declare(strict_types=1);

namespace Domain\Security;

use Domain\Exception\OperationDeniedException;
use Domain\Model\User;

interface AccessControl
{
    /**
     * @param ?User $user The user performing the action, defaults to the current logged-in user if null
     *
     * @throws OperationDeniedException
     */
    public function requires(Operation $operation, mixed $context = null, ?User $user = null): void;

    /**
     * @param ?User $user The user performing the action, defaults to the current logged-in user if null
     */
    public function isAllowed(Operation $operation, mixed $context = null, ?User $user = null): bool;
}
