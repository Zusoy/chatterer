<?php

declare(strict_types=1);

namespace Domain\Message\Channel;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class ListUsers implements Message
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
