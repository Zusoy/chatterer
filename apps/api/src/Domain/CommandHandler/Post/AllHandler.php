<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Post;

use Domain\Command\Post as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Forum\Post;
use Domain\Repository\Posts;
use Domain\Repository\Subjects;

final class AllHandler
{
    public function __construct(
        private readonly Subjects $subjects,
        private readonly Posts $posts
    ) {
    }

    /**
     * @return iterable<Post>
     */
    public function __invoke(Command\All $command): iterable
    {
        if (!$subject = $this->subjects->find($command->getSubjectIdentifier())) {
            throw new ObjectNotFoundException('Subject', $command->subjectId);
        }

        return $this->posts->findAll($subject);
    }
}
