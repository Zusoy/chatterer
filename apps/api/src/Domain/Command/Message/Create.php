<?php

declare(strict_types=1);

namespace Domain\Command\Message;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Create
{
    public function __construct(
        public readonly string $authorId,
        public readonly string $channelId,
        public readonly string $content
    ) {
        Assert::lazy()
            ->that($authorId, propertyPath: 'authorId')->identifier()
            ->that($channelId, propertyPath: 'channelId')->identifier()
            ->that($content, propertyPath: 'content')->notEmpty()
            ->verifyNow();
    }

    public function getAuthorId(): Identifier
    {
        return new Identifier($this->authorId);
    }

    public function getChannelId(): Identifier
    {
        return new Identifier($this->channelId);
    }
}
