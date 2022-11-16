<?php

namespace Domain\Message\Channel;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class Join implements Message
{
    public function __construct(private string $channelId, private string $userId)
    {
        Assert::lazy()
            ->that($channelId, propertyPath: 'channelId')
                ->identifier()
            ->that($userId, propertyPath: 'userId')
                ->identifier()
            ->verifyNow();
    }

    public function getChannelIdentifier(): Identifier
    {
        return new Identifier($this->channelId);
    }

    public function getUserIdentifier(): Identifier
    {
        return new Identifier($this->userId);
    }
}
