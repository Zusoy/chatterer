<?php

namespace Domain\Message\Message;

use Domain\Identity\Identifier;
use Domain\Message;
use Infra\Assert\Assert;

class Create implements Message
{
    public function __construct(
        private string $channelId,
        private string $content
    ) {
        Assert::lazy()
            ->that($channelId, propertyPath: 'channelId')->identifier()
            ->that($content, propertyPath: 'content')->notEmpty()
            ->verifyNow();
    }

    public function getChannelId(): Identifier
    {
        return new Identifier($this->channelId);
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
