<?php

declare(strict_types=1);

namespace Domain\Security\Rule;

use Domain\Model\Channel as ChannelModel;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Security\Operation;
use Domain\Security\Rule;

/**
 * @phpstan-type ChannelContext array{channel: ChannelModel, station: Station}
 */
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
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @param ChannelContext $context
     */
    public function allows(User $user, Operation $operation, mixed $context = null): bool
    {
        return match($operation) {
            Operation::DELETE_CHANNEL,
            Operation::UPDATE_CHANNEL,
            Operation::CREATE_CHANNEL => $user->isAdmin(),

            default => $user->isAdmin()
        };
    }
}
