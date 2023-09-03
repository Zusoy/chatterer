<?php

declare(strict_types=1);

namespace spec\Domain\Model\Forum;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Forum\Forum;
use Domain\Model\Forum\Subject;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;

class SubjectSpec extends ObjectBehavior
{
    public function let(Forum $forum): void
    {
        $forum->getName()->willReturn('Forum');
        $forum->getIdentifier()->willReturn(
            new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb')
        );

        $this->beConstructedWith(
            'Subject title',
            $forum
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Subject::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
    }

    public function it_exposes_some_state(Forum $forum): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getTitle()->shouldBe('Subject title');
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getForum()->shouldBeLike($forum);
        $this->getForumIdentifier()->shouldBeLike(new Identifier('41400600-16b8-45b5-bf4c-fd1d8e3ed9cb'));
        $this->getForumName()->shouldBe('Forum');
    }
}
