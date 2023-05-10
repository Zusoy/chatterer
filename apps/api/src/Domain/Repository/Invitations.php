<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Model\Invitation;
use Domain\Model\Station;

interface Invitations
{
    public function add(Invitation $invitation): void;

    public function findByStation(Station $station): ?Invitation;

    public function findByToken(string $token, Station $station): ?Invitation;

    public function remove(Invitation $invitation): void;
}
