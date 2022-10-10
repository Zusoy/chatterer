<?php

namespace Infra\Assert;

use Assert\Assertion as BaseAssertion;
use Assert\AssertionFailedException;
use Domain\Identity\Identifier;

class Assertion extends BaseAssertion
{
    /**
     * Assert that the value is a valid Identifier
     *
     * @param mixed $value
     * @param string|callable|null $message
     *
     * @throws AssertionFailedException
     */
    public static function identifier($value, $message = null, string $propertyPath = null): bool
    {
        static::notEmpty($value, $message, $propertyPath);
        static::regex($value, sprintf('/%s/', Identifier::PATTERN), $message, $propertyPath);

        return true;
    }
}
