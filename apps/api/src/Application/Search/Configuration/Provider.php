<?php

declare(strict_types=1);

namespace Application\Search\Configuration;

interface Provider
{
    /**
     * @return array<mixed>
     */
    public function getConfig(): array;
}
