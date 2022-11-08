<?php

namespace spec\Domain\Model;

use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Invitation;
use Domain\Model\Station;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;

class InvitationSpec extends ObjectBehavior
{
    public function let(Station $station): void
    {
        $station->getIdentifier()->willReturn(
            new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb')
        );

        $this->beConstructedWith($station);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Invitation::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
    }

    public function it_exposes_some_state(Station $station): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getStation()->shouldBeLike($station);
        $this->getStationIdentifier()->shouldBeLike(new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb'));
    }
}
