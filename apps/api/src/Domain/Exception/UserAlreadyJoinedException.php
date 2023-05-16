<?php

declare(strict_types=1);

namespace Domain\Exception;

use Domain\Group\UserGroup;
use Domain\Model\User;
use InvalidArgumentException;

final class UserAlreadyJoinedException extends InvalidArgumentException
{
    public function __construct(UserGroup $group, User $user)
    {
        parent::__construct("The User {$user} already joined this group : {$group}");
    }
}
