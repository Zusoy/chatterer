<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Subject;

use Domain\Command\Subject as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Forum\Subject;
use Domain\Repository\Forums;
use Domain\Repository\Subjects;

final class AllHandler
{
    public function __construct(
        private readonly Forums $forums,
        private readonly Subjects $subjects
    ) {
    }

    /**
     * @return iterable<Subject>
     */
    public function __invoke(Command\All $command): iterable
    {
        if (!$forum = $this->forums->find($command->getForumIdentifier())) {
            throw new ObjectNotFoundException('Forum', $command->forumId);
        }

        return $this->subjects->findAll($forum);
    }
}
