<?php

declare(strict_types=1);

namespace spec\Domain\Model;

use DateTimeImmutable;
use Domain\Group\UserGroup;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;

class StationSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(
            'My Station',
            'Station description'
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Station::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
        $this->shouldImplement(UserGroup::class);
    }

    public function it_exposes_some_state(): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getName()->shouldBe('My Station');
        $this->getDescription()->shouldBe('Station description');
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);
    }

    public function it_contains_users(User $user1, User $user2): void
    {
        $this->addUser($user1);
        $this->hasUser($user1)->shouldBe(true);
        $this->hasUser($user2)->shouldBe(false);
    }
}
