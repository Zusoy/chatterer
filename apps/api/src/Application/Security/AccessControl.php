<?php

declare(strict_types=1);

namespace Application\Security;

use Domain\Exception\OperationDeniedException;
use Domain\Model\User;
use Domain\Security\Operation;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class AccessControl implements \Domain\Security\AccessControl
{
    public function __construct(private AuthorizationCheckerInterface $checker)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function requires(Operation $operation, mixed $context = null, ?User $user = null): void
    {
        if (!$this->isAllowed($operation, $context, $user)) {
            throw new OperationDeniedException("Operation '$operation->value' is not permitted.");
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isAllowed(Operation $operation, mixed $context = null, ?User $user = null): bool
    {
        return $this->checker->isGranted(
            $operation->value,
            [
                'context' => $context,
                'user' => $user
            ]
        );
    }
}
