<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Forum\Forum;
use Domain\Model\Station;

interface Forums
{
    public function add(Forum $forum): void;

    public function find(Identifier $identifier): ?Forum;

    /**
     * @return iterable<Forum>
     */
    public function findAll(Station $station): iterable;
}
