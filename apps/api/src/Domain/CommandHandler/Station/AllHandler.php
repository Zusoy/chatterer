<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Station;

use Domain\Command\Station as Command;
use Domain\Model\Station;
use Domain\Repository\Stations;

final class AllHandler
{
    public function __construct(private readonly Stations $stations)
    {
    }

    /**
     * @return iterable<Station>
     */
    public function __invoke(Command\All $command): iterable
    {
        return $this->stations->findAll();
    }
}
