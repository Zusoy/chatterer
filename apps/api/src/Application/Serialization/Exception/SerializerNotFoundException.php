<?php

declare(strict_types=1);

namespace Application\Serialization\Exception;

use Exception;

class SerializerNotFoundException extends Exception
{
    public function __construct(string $format)
    {
        parent::__construct("Serializer not found for format {$format}", 2404);
    }
}
