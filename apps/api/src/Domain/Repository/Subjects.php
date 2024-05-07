<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Forum\Forum;
use Domain\Model\Forum\Subject;

interface Subjects
{
    public function add(Subject $subject): void;

    public function find(Identifier $identifier): ?Subject;

    /**
     * @return iterable<Subject>
     */
    public function findAll(Forum $forum): iterable;
}
