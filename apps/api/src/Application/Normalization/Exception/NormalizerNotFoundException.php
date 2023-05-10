<?php

namespace Application\Normalization\Exception;

use Exception;

class NormalizerNotFoundException extends Exception
{
    public function __construct(string $objectName)
    {
        parent::__construct("Normalizer not found for object {$objectName}", 2404);
    }
}
