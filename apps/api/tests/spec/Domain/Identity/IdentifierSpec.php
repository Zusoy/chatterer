<?php

namespace spec\Domain\Identity;

use Assert\AssertionFailedException;
use Domain\Identity\Identifier;
use PhpSpec\ObjectBehavior;
use Stringable;

class IdentifierSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('013ac977-2287-4a6d-b1ec-df7bafb62907');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Identifier::class);
        $this->shouldImplement(Stringable::class);
    }

    public function it_valids_its_value(): void
    {
        $this->beConstructedWith('TEST');
        $this->shouldThrow(AssertionFailedException::class)->duringInstantiation();
    }

    public function it_can_be_generated(): void
    {
        $this->shouldNotThrow()->duringInstantiation();
        $this->beConstructedThrough('generate');
    }
}
