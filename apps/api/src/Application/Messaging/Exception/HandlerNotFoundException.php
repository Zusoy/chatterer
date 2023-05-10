<?php

declare(strict_types=1);

namespace Application\Messaging\Exception;

use Exception;

class HandlerNotFoundException extends Exception
{
    public function __construct(string $messageName)
    {
        parent::__construct("Handler not found for message {$messageName}", 1404);
    }
}
