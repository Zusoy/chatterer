<?php

declare(strict_types=1);

namespace Application\HTTP\Payload\Station;

final class Join
{
    public function __construct(public readonly string $token)
    {
    }
}
