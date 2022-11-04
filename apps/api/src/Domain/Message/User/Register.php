<?php

namespace Domain\Message\User;

use Assert\Assert;
use Domain\Message;

class Register implements Message
{
    public function __construct(
        private string $firstname,
        private string $lastname,
        private string $email,
        private string $password
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

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
