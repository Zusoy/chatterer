<?php

declare(strict_types=1);

namespace Application\HTTP\Payload\Message;

final class Create
{
    public function __construct(public readonly string $content)
    {
    }
}
