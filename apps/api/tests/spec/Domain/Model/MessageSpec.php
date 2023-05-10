<?php

declare(strict_types=1);

namespace spec\Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\User;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    public function let(User $author, Channel $channel): void
    {
        $author->getIdentifier()->willReturn(
            new Identifier('6d683ee5-5d60-4b67-8935-34b59cb834f9')
        );
        $author->__toString()->willReturn('Hello World');

        $channel->getName()->willReturn('Channel Name');
        $channel->getIdentifier()->willReturn(
            new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb')
        );

        $this->beConstructedWith($author, 'Hello World !', $channel);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Message::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
    }

    public function it_exposes_some_state(User $author, Channel $channel): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getContent()->shouldBe('Hello World !');
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getAuthor()->shouldBeLike($author);
        $this->getAuthorIdentifier()->shouldBeLike(new Identifier('6d683ee5-5d60-4b67-8935-34b59cb834f9'));
        $this->getAuthorName()->shouldBe('Hello World');
        $this->getChannel()->shouldBeLike($channel);
        $this->getChannelName()->shouldBe('Channel Name');
        $this->getChannelIdentifier()->shouldBeLike(new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb'));
    }
}
