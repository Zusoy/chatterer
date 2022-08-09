<?php

namespace Test\Integrations\Matcher\Assert;

final class PropertyAssertionFailure
{
    private string $name;
    private ?string $assert;

    public static function at(string $name, ?string $assert = null)
    {
        return new self($name, $assert);
    }

    private function __construct(string $name, ?string $assert = null)
    {
        $this->name = $name;
        $this->assert = $assert;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAssert(): ?string
    {
        return $this->assert;
    }
}
