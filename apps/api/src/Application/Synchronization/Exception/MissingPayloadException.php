<?php

declare(strict_types=1);

namespace Application\Synchronization\Exception;

use InvalidArgumentException;
use Throwable;

final class MissingPayloadException extends InvalidArgumentException
{
    public function __construct(string $context, Throwable $previous = null)
    {
        parent::__construct(sprintf('Missing synchronization payload for context %s', $context), 0, $previous);
    }
}
