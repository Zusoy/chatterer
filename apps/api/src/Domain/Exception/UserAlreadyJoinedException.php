<?php

namespace Domain\Exception;

use Domain\Model\HasUsers;
use Domain\Model\User;
use InvalidArgumentException;

final class UserAlreadyJoinedException extends InvalidArgumentException
{
    public function __construct(HasUsers $group, User $user)
    {
        parent::__construct("The User {$user} already joined this group : {$group}");
    }
}
