<?php

declare(strict_types=1);

namespace Domain\Command\Subject;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class All
{
    public function __construct(public readonly string $forumId)
    {
        Assert::that($forumId, defaultPropertyPath: 'forumId')->identifier();
    }

    public function getForumIdentifier(): Identifier
    {
        return new Identifier($this->forumId);
    }
}
