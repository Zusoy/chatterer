<?php

namespace Application\Serializer\Exception;

use Exception;

class SerializerNotFoundException extends Exception
{
    public function __construct(string $format)
    {
        parent::__construct("Serializer not found for format {$format}", 3404);
    }
}
