<?php

declare(strict_types=1);

namespace Domain\Identity;

use Assert\Assert;
use Ramsey\Uuid\Uuid;
use Stringable;

final class Identifier implements Stringable
{
    public const PATTERN = '\A[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}\z';

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

