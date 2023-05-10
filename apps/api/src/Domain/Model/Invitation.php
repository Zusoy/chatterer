<?php

declare(strict_types=1);

namespace Domain\Model;

use DateTimeImmutable;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\Link\LinkToken;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Invitation implements Identifiable, HasTimestamp
{
    use HasTimestampTrait;

    private Identifier $id;
    private Station $station;
    private LinkToken $token;

    public function __construct(Station $station)
    {
        $this->id = Identifier::generate();
        $this->token = LinkToken::generate();
        $this->station = $station;

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

    public function getToken(): LinkToken
    {
        return $this->token;
    }
}
