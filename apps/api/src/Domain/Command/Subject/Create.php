<?php

declare(strict_types=1);

namespace Domain\Command\Subject;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Create
{
    public function __construct(public readonly string $title, public readonly string $forumId)
    {
        Assert::that($title, defaultPropertyPath: 'title')->notEmpty();
        Assert::that($forumId, defaultPropertyPath: 'forumId')->identifier();
    }

    public function getForumIdentifier(): Identifier
    {
        return new Identifier($this->forumId);
    }
}
