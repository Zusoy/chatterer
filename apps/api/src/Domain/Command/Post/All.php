<?php

declare(strict_types=1);

namespace Domain\Command\Post;

use Domain\Identity\Identifier;
use Infra\Assert\Assert;

final class All
{
    public function __construct(public readonly string $subjectId)
    {
        Assert::that($subjectId, defaultPropertyPath: 'subjectId')->identifier();
    }

    public function getSubjectIdentifier(): Identifier
    {
        return new Identifier($this->subjectId);
    }
}
