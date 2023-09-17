<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Post;

use Domain\Command\Post as Command;
use Domain\Event\Post as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Forum\Post;
use Domain\Repository\Posts;
use Domain\Repository\Subjects;
use Domain\Repository\Users;

final class CreateHandler
{
    public function __construct(
        private readonly Subjects $subjects,
        private readonly Users $users,
        private readonly Posts $posts,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Create $command): Post
    {
        if (!$subject = $this->subjects->find($command->getSubjectIdentifier())) {
            throw new ObjectNotFoundException('Subject', $command->subjectId);
        }

        if (!$author = $this->users->find($command->getAuthorIdentifier())) {
            throw new ObjectNotFoundException('User', $command->authorId);
        }

        $post = new Post(
            content: $command->content,
            author: $author,
            subject: $subject
        );

        $this->posts->add($post);
        $this->eventLog->record(new Event\Created($post));

        return $post;
    }
}
