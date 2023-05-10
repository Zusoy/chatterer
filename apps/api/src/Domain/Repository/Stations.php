<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Station;

interface Stations
{
    public function add(Station $station): void;

    public function find(Identifier $identifier): ?Station;

    public function findByName(string $name): ?Station;

    /**
     * @return iterable<Station>
     */
    public function findAll(): iterable;

    public function remove(Station $station): void;
}
