<?php

declare(strict_types=1);

namespace Domain\Command\Message;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class All
{
    public function __construct(public readonly string $channelId)
    {
        Assert::that($channelId, defaultPropertyPath: 'channelId')->identifier();
    }

    public function getChannelId(): Identifier
    {
        return new Identifier($this->channelId);
    }
}
