<?php

namespace Domain\Identity;

use Assert\Assert;
use Ramsey\Uuid\Uuid;
use Stringable;

final class Identifier implements Stringable
{
    public const PATTERN = Uuid::VALID_PATTERN;

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function __construct(private string $id)
    {
        Assert::that($id, defaultPropertyPath: 'id')
            ->notEmpty()
            ->regex(sprintf('/%s/', self::PATTERN))
        ;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}

