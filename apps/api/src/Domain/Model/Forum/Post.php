<?php

declare(strict_types=1);

namespace Domain\Model\Forum;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\User;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;
use Stringable;

class Post implements Identifiable, HasTimestamp, Stringable
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $content;
    private User $author;
    private Subject $subject;

    public function __construct(string $content, User $author, Subject $subject)
    {
        $this->id = Identifier::generate();
        $this->content = $content;
        $this->author = $author;
        $this->subject = $subject;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getAuthorIdentifier(): Identifier
    {
        return $this->author->getIdentifier();
    }

    public function getAuthorName(): string
    {
        return (string) $this->author;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getSubjectIdentifier(): Identifier
    {
        return $this->subject->getIdentifier();
    }

    public function getSubjectTitle(): string
    {
        return $this->subject->getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->content;
    }
}
