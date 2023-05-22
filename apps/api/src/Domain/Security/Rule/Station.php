<?php

declare(strict_types=1);

namespace Domain\Security\Rule;

use Domain\Model\Station as StationModel;
use Domain\Model\User;
use Domain\Security\Operation;
use Domain\Security\Rule;

/**
 * @phpstan-type StationContext array{station: StationModel}
 */
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
            Operation::DELETE_STATION,
            Operation::INVITE_STATION,
            Operation::LIST_STATION_CHANNELS,
            Operation::LIST_STATION_USERS,
            Operation::DELETE_INVITATION,
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @param StationContext $context
     */
    public function allows(User $user, Operation $operation, mixed $context = null): bool
    {
        return match($operation) {
            Operation::DELETE_STATION,
            Operation::UPDATE_STATION,
            Operation::CREATE_STATION => $user->isAdmin(),
            Operation::LIST_STATION_CHANNELS,
            Operation::LIST_STATION_USERS,
            Operation::DELETE_INVITATION,
            Operation::INVITE_STATION => ($context !== null && $user->isInStation($context['station'])) || $user->isAdmin(),

            default => $user->isAdmin()
        };
    }
}
