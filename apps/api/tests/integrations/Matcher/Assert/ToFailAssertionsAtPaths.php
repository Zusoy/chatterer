<?php

declare(strict_types=1);

namespace Test\Integrations\Matcher\Assert;

use Assert\InvalidArgumentException;
use Assert\LazyAssertionException;
use Test\Integrations\Matcher\Assert\PropertyAssertionFailure;
use Throwable;

final class ToFailAssertionsAtPaths
{
    /**
     * @param PropertyAssertionFailure[] $propertyPaths
     */
    public static function match(callable $actual, array $propertyPaths)
    {
        $assertionException = static::actual($actual);

        if (!$assertionException instanceof LazyAssertionException) {
            return false;
        }

        if (count($assertionException->getErrorExceptions()) !== count($propertyPaths)) {
            return false;
        }

        foreach ($propertyPaths as $propertyPath) {
            $propertyException = static::getPathException($assertionException, $propertyPath->getName());

            if (null === $propertyException) {
                return false;
            }

            if ($assert = $propertyPath->getAssert()) {
                $constraints = $propertyException->getConstraints();

                if (!count($constraints)) {
                    return false;
                }

                if (!in_array($assert, array_keys($constraints))) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function actual(callable $actual)
    {
        try {
            $actual();
        } catch (Throwable $e) {
            return $e;
        }
    }

    public static function description(): string
    {
        return "assertion failed";
    }

    private static function getPathException(LazyAssertionException $exception, string $path): ?InvalidArgumentException
    {
        foreach ($exception->getErrorExceptions() as $errorException) {
            if ($errorException->getPropertyPath() === $path) {
                return $errorException;
            }
        }

        return null;
    }
}
