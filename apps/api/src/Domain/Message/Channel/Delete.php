<?php

declare(strict_types=1);

namespace Domain\Message\Channel;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class Delete implements Message
{
    public function __construct(private string $id)
    {
        Assert::lazy()
            ->that($id, propertyPath: 'id')->identifier()
            ->verifyNow();
    }

    public function getIdentifier(): Identifier
    {
        return new Identifier($this->id);
    }
}
