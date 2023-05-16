<?php

declare(strict_types=1);

namespace Domain\Group;

use Domain\Model\User;
use Stringable;

interface UserGroup extends Stringable
{
    public function hasUser(User $user): bool;

    public function addUser(User $user): void;

    public function removeUser(User $user): void;

    /**
     * @return iterable<User>
     */
    public function getUsers(): iterable;
}
