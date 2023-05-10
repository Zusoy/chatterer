<?php

declare(strict_types=1);

namespace Domain\Model\User;

trait ImmutableCredentialsTrait
{
    /**
     * {@inheritDoc}
     */
    public function eraseCredentials(): void
    {
    }
}
