<?php

declare(strict_types=1);

namespace Domain\Security\Rule;

use Domain\Model\Forum\Forum as ForumModel;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Security\Operation;
use Domain\Security\Rule;

/**
 * @phpstan-type ForumContext array{forum: ForumModel, station: Station}
 */
final class Forum implements Rule
{
    /**
     * {@inheritDoc}
     */
    public function getOperations(): array
    {
        return [
            Operation::CREATE_FORUM,
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @param ForumContext $context
     */
    public function allows(User $user, Operation $operation, mixed $context = null): bool
    {
        return match($operation) {
            Operation::CREATE_FORUM => $user->isAdmin(),

            default => $user->isAdmin()
        };
    }
}
