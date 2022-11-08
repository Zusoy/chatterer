<?php

namespace Domain\Exception;

use Domain\Model\HasCommunity;
use Domain\Model\User;
use InvalidArgumentException;

final class UserAlreadyJoinedException extends InvalidArgumentException
{
    public function __construct(HasCommunity $group, User $user)
    {
        parent::__construct("The User {$user} already joined this group : {$group}");
    }
}