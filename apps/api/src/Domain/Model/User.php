<?php

namespace Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\User\ImmutableCredentialsTrait;
use Domain\Model\User\Role;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;
use Stringable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements Identifiable, HasTimestamp, UserInterface, PasswordAuthenticatedUserInterface, Stringable
{
    use HasTimestampTrait;
    use ImmutableCredentialsTrait;

    private Identifier $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private Role $role;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $password
    ) {
        $this->id = Identifier::generate();
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = Role::USER;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
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

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(): array
    {
        return [ $this->role->value ];
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function __toString(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }
}