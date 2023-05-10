<?php

declare(strict_types=1);

namespace Domain\Exception;

use InvalidArgumentException;
use Throwable;

class ObjectAlreadyExistsException extends InvalidArgumentException
{
    public function __construct(string $objectName, string $objectIdentifier, ?Throwable $previous = null)
    {
        parent::__construct("{$objectName} with id {$objectIdentifier} already exists.", 1, $previous);
    }
}
