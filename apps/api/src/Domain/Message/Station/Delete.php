<?php

namespace Domain\Message\Station;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class Delete implements Message
{
    public function __construct(private string $id)
    {
        Assert::lazy()
            ->that($id, propertyPath: 'id')->identifier()
            ->verifyNow()
        ;
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
    }
}
