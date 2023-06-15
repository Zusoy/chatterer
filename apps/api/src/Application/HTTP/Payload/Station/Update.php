<?php

declare(strict_types=1);

namespace Application\HTTP\Payload\Station;

final class Update
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description
    ) {
    }
}
