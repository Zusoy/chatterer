<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Invitation;
use Domain\Model\Station;

interface Invitations
{
    public function add(Invitation $invitation): void;

    public function find(Identifier $identifier): ?Invitation;

    public function findByToken(string $token): ?Invitation;

    public function findByStation(Station $station): ?Invitation;

    public function remove(Invitation $invitation): void;
}
