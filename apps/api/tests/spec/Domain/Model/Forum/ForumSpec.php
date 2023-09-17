<?php

declare(strict_types=1);

namespace spec\Domain\Model\Forum;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Forum\Forum;
use Domain\Model\Station;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;

class ForumSpec extends ObjectBehavior
{
    public function let(Station $station): void
    {
        $station->getName()->willReturn('Station');
        $station->getIdentifier()->willReturn(
            new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb')
        );

        $this->beConstructedWith(
            'Forum name',
            $station
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Forum::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
    }

    public function it_exposes_some_state(Station $station): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getName()->shouldBe('Forum name');
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getStation()->shouldBeLike($station);
        $this->getStationIdentifier()->shouldBeLike(new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb'));
        $this->getStationName()->shouldBe('Station');
    }
}
