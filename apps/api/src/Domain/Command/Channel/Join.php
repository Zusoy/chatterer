<?php

declare(strict_types=1);

namespace Domain\Command\Channel;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Join
{
    public function __construct(
        public readonly string $channelId,
        public readonly string $userId
    ) {
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
