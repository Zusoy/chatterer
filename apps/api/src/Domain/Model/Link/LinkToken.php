<?php

namespace Domain\Model\Link;

use Assert\Assert;
use Stringable;

final class LinkToken implements Stringable
{
    private const ALGO = 'sha512';
    private const ENTROPY = 128;

    private string $value;

    public static function generate(): self
    {
        return new self(hash(self::ALGO, random_bytes(self::ENTROPY)));
    }

    private function __construct(string $value)
    {
        Assert::that($value)->notEmpty();

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
