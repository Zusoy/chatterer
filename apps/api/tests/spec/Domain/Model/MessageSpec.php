<?php

namespace spec\Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    public function let(Channel $channel): void
    {
        $channel->getName()->willReturn('Channel Name');
        $channel->getIdentifier()->willReturn(
            new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb')
        );

        $this->beConstructedWith('Hello World !', $channel);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Message::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
    }

    public function it_exposes_some_state(Channel $channel): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getContent()->shouldBe('Hello World !');
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getChannel()->shouldBeLike($channel);
        $this->getChannelName()->shouldBe('Channel Name');
        $this->getChannelIdentifier()->shouldBeLike(new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb'));
    }
}
