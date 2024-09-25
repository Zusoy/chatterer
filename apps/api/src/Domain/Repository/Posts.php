<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Forum\Post;
use Domain\Model\Forum\Subject;

interface Posts
{
    public function add(Post $post): void;

    public function find(Identifier $identifier): ?Post;

    /**
     * @return iterable<Post>
     */
    public function findAll(Subject $subject): iterable;
}
