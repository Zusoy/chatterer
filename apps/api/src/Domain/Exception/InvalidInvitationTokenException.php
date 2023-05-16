<?php

declare(strict_types=1);

namespace Domain\Exception;

use InvalidArgumentException;

class InvalidInvitationTokenException extends InvalidArgumentException
{
    public function __construct(string $token)
    {
        parent::__construct("The invitation with token {$token} does not exists.");
    }
}
