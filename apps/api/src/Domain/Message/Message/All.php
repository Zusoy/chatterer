<?php

declare(strict_types=1);

namespace Domain\Message\Message;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class All implements Message
{
    public function __construct(private string $channelId)
    {
        Assert::lazy()
            ->that($channelId, propertyPath: 'channelId')->identifier()
            ->verifyNow();
    }

    public function getChannelId(): Identifier
    {
        return new Identifier($this->channelId);
    }
}
