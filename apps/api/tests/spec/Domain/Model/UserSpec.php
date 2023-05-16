<?php

declare(strict_types=1);

namespace spec\Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\User;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(
            'John',
            'Doe',
            'john.doe@gmail.com',
            'hello@123'
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(User::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
        $this->shouldImplement(UserInterface::class);
        $this->shouldImplement(PasswordAuthenticatedUserInterface::class);
    }

    public function it_exposes_some_state(): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getFirstname()->shouldBe('John');
        $this->getLastname()->shouldBe('Doe');
        $this->getEmail()->shouldBe('john.doe@gmail.com');
        $this->getPassword()->shouldBe('hello@123');
        $this->isAdmin()->shouldBe(false);
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);
    }
}
