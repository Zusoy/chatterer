<?php

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Channel;

interface Channels
{
    public function add(Channel $channel): void;

    public function find(Identifier $identifier): ?Channel;

    public function findByName(Identifier $stationId, string $name): ?Channel;

    public function remove(Channel $channel): void;
}
