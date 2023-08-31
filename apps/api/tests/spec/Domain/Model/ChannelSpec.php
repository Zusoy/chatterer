<?php

declare(strict_types=1);

namespace spec\Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Station;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;
use Stringable;

class ChannelSpec extends ObjectBehavior
{
    public function let(Station $station): void
    {
        $station->getName()->willReturn('Station');
        $station->getIdentifier()->willReturn(
            new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb')
        );

        $this->beConstructedWith(
            $station,
            'My Channel',
            'Channel description'
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Channel::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
        $this->shouldImplement(Stringable::class);
    }

    public function it_exposes_some_state(Station $station): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getName()->shouldBe('My Channel');
        $this->getDescription()->shouldBe('Channel description');
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getStation()->shouldBeLike($station);
        $this->getStationIdentifier()->shouldBeLike(new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb'));
        $this->getStationName()->shouldBe('Station');
    }
}
