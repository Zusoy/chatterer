<?php

declare(strict_types=1);

namespace Domain\Security;

use Domain\Model\User;

interface PasswordHasher
{
    public function hash(User $user, string $password): string;
}
