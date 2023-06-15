<?php

declare(strict_types=1);

namespace Application\HTTP\Payload\User;

final class Create
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
        public readonly string $password,
        public readonly bool $isAdmin = false
    ) {
    }
}
