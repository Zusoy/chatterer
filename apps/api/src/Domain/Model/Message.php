<?php

namespace Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Message implements Identifiable, HasTimestamp
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $content;
    private Channel $channel;

    public function __construct(string $content, Channel $channel)
    {
        $this->id = Identifier::generate();
        $this->content = $content;
        $this->channel = $channel;

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

    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
