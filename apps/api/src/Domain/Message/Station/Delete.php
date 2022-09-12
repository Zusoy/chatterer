<?php

namespace Domain\Message\Station;

use Assert\Assert;
use Domain\Identity\Identifier;
use Domain\Message;

class Delete implements Message
{
    public function __construct(private string $id)
    {
        Assert::lazy()
            ->that($id, propertyPath: 'id')->notEmpty()->regex(sprintf('/%s/', Identifier::PATTERN))
            ->verifyNow()
        ;
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
    }
}
