<?php

declare(strict_types=1);

namespace Domain\Command\Post;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class Create
{
    public function __construct(
        public readonly string $content,
        public readonly string $authorId,
        public readonly string $subjectId
    ) {
        Assert::that($content, defaultPropertyPath: 'content')->notEmpty();
        Assert::that($authorId, defaultPropertyPath: 'authorId')->identifier();
        Assert::that($subjectId, defaultPropertyPath: 'subjectId')->identifier();
    }

    public function getAuthorIdentifier(): Identifier
    {
        return new Identifier($this->authorId);
    }

    public function getSubjectIdentifier(): Identifier
    {
        return new Identifier($this->subjectId);
    }
}
