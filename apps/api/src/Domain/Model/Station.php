<?php

namespace Domain\Model;

use DateTimeImmutable;
use Domain\Model\Identity\Identifiable;
use Domain\Model\Identity\Identifier;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Station implements Identifiable, HasTimestamp
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $name;
    private ?string $description;

    public function __construct(string $name, ?string $description)
    {
        $this->id = Identifier::generate();
        $this->name = $name;
        $this->description = $description;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
