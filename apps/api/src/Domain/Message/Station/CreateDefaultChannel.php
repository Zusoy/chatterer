<?php

namespace Domain\Message\Station;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class CreateDefaultChannel implements Message
{
    public function __construct(private string $id)
    {
        Assert::that($id, defaultPropertyPath: 'id')->identifier();
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
    }
}
