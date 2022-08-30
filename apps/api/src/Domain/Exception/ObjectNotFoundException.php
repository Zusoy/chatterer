<?php

namespace Domain\Exception;

use InvalidArgumentException;
use Throwable;

class ObjectNotFoundException extends InvalidArgumentException
{
    public function __construct(string $objectName, string $objectIdentifier, ?Throwable $previous = null)
    {
        parent::__construct("{$objectName} with identifier {$objectIdentifier} does not exist.", 0, $previous);
    }
}
