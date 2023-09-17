<?php

declare(strict_types=1);

namespace Domain\Model\Forum;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Station;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Forum implements Identifiable, HasTimestamp
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $name;
    private Station $station;

    public function __construct(string $name, Station $station)
    {
        $this->id = Identifier::generate();
        $this->name = $name;
        $this->station = $station;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
    }

    public function getStationIdentifier(): Identifier
    {
        return $this->station->getIdentifier();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStationName(): string
    {
        return $this->station->getName();
    }

    public function getStation(): Station
    {
        return $this->station;
    }
}
