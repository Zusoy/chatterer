<?php

namespace Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Channel implements Identifiable, HasTimestamp
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $name;
    private ?string $description;
    private Station $station;

    public function __construct(Station $station, string $name, ?string $description)
    {
        $this->id = Identifier::generate();
        $this->station = $station;
        $this->name = $name;
        $this->description = $description;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function getStationIdentifier(): Identifier
    {
        return $this->station->getIdentifier();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
