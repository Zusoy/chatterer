<?php

declare(strict_types=1);

namespace Domain\Model\User;

enum Role: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
}
