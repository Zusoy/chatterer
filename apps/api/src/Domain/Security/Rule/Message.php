<?php

declare(strict_types=1);

namespace Domain\Security\Rule;

use Domain\Model\Channel;
use Domain\Model\Message as ModelMessage;
use Domain\Model\User;
use Domain\Security\Operation;
use Domain\Security\Rule;

/**
 * @phpstan-type MessageContext array{channel: Channel, message: ModelMessage}
 */
final class Message implements Rule
{
    /**
     * {@inheritDoc}
     */
    public function getOperations(): array
    {
        return [
            Operation::CREATE_MESSAGE,
            Operation::DELETE_MESSAGE
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @param MessageContext $context
     */
    public function allows(User $user, Operation $operation, mixed $context = null): bool
    {
        return match($operation) {
            Operation::CREATE_MESSAGE => ($context !== null && $user->isInChannel($context['channel'])),
            Operation::DELETE_MESSAGE => ($context !== null && $user->isAuthorOf($context['message'])) || $user->isAdmin(),

            default => $user->isAdmin()
        };
    }
}
