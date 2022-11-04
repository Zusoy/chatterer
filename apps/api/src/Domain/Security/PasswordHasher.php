<?php

namespace Domain\Security;

use Domain\Model\User;

interface PasswordHasher
{
    public function hash(User $user, string $password): string;
}
