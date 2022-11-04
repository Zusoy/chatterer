<?php

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\User;

interface Users
{
    public function add(User $user): void;

    public function find(Identifier $identifier): ?User;

    public function findByEmail(string $email): ?User;
}
