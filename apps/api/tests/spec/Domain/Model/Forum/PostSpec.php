<?php

declare(strict_types=1);

namespace spec\Domain\Model\Forum;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Forum\Post;
use Domain\Model\Forum\Subject;
use Domain\Model\User;
use Domain\Time\HasTimestamp;
use PhpSpec\ObjectBehavior;
use Stringable;

class PostSpec extends ObjectBehavior
{
    public function let(User $author, Subject $subject): void
    {
        $author->getIdentifier()->willReturn(
            new Identifier('479bf8fc-42c6-4b02-ba37-8872d19a8f1a')
        );

        $author->__toString()->willReturn('John Doe');

        $subject->getIdentifier()->willReturn(
            new Identifier('e0665042-559b-4de2-aaf0-ab86d6cdc7bb')
        );

        $subject->getTitle()->willReturn('Title');

        $this->beConstructedWith(
            'content',
            $author,
            $subject
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Post::class);
        $this->shouldImplement(Identifiable::class);
        $this->shouldImplement(HasTimestamp::class);
        $this->shouldImplement(Stringable::class);
    }

    public function it_exposes_some_state(User $author, Subject $subject): void
    {
        $this->getIdentifier()->shouldHaveType(Identifier::class);
        $this->getContent()->shouldBe('content');
        $this->getCreatedAt()->shouldHaveType(DateTimeImmutable::class);
        $this->getUpdatedAt()->shouldHaveType(DateTimeImmutable::class);

        $this->getAuthor()->shouldBeLike($author);
        $this->getAuthorIdentifier()->shouldBeLike(new Identifier('479bf8fc-42c6-4b02-ba37-8872d19a8f1a'));
        $this->getAuthorName()->shouldBe('John Doe');

        $this->getSubject()->shouldBeLike($subject);
        $this->getSubjectIdentifier()->shouldBeLike(new Identifier('e0665042-559b-4de2-aaf0-ab86d6cdc7bb'));
        $this->getSubjectTitle()->shouldBe('Title');
    }
}
