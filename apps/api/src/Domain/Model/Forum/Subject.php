<?php

declare(strict_types=1);

namespace Domain\Model\Forum;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Subject implements Identifiable, HasTimestamp
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $title;
    private Forum $forum;

    public function __construct(string $title, Forum $forum)
    {
        $this->id = Identifier::generate();
        $this->title = $title;
        $this->forum = $forum;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
    }

    public function getForumIdentifier(): Identifier
    {
        return $this->forum->getIdentifier();
    }

    public function getForumName(): string
    {
        return $this->forum->getName();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getForum(): Forum
    {
        return $this->forum;
    }
}
