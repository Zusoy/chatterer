<?php

declare(strict_types=1);

namespace Application\HTTP\Payload\Channel;

final class Create
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description
    ) {
    }
}
