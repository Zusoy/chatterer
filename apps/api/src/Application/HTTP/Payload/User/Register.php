<?php

declare(strict_types=1);

namespace Application\HTTP\Payload\User;

final class Register
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
