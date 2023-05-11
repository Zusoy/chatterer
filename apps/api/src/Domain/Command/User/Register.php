<?php

declare(strict_types=1);

namespace Domain\Command\User;

use Infra\Assert\Assert;

final class Register
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
        public readonly string $password
    ) {
        Assert::lazy()
            ->that($firstname, propertyPath: 'firstname')
                ->notEmpty()
            ->that($lastname, propertyPath: 'lastname')
                ->notEmpty()
            ->that($email, propertyPath: 'email')
                ->notEmpty()
                ->email()
            ->that($password, propertyPath: 'password')
                ->notEmpty()
                ->minLength(8)
            ->verifyNow()
        ;
    }
}
