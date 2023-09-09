<?php

declare(strict_types=1);

namespace Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;
use Stringable;

class Message implements Identifiable, HasTimestamp, Stringable
{
    use HasTimestampTrait;

    private Identifier $id;
    private User $author;
    private string $content;
    private Channel $channel;

    public function __construct(User $author, string $content, Channel $channel)
    {
        $this->id = Identifier::generate();
        $this->author = $author;
        $this->content = $content;
        $this->channel = $channel;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
    }

    public function getChannelIdentifier(): Identifier
    {
        return $this->channel->getIdentifier();
    }

    public function getChannelName(): string
    {
        return $this->channel->getName();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
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

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->content;
    }
}
