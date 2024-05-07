<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Subject;

use Domain\Command\Subject as Command;
use Domain\Event\Subject as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Forum\Subject;
use Domain\Repository\Forums;
use Domain\Repository\Subjects;

final class CreateHandler
{
    public function __construct(
        private readonly Forums $forums,
        private readonly Subjects $subjects,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Create $command): Subject
    {
        if (!$forum = $this->forums->find($command->getForumIdentifier())) {
            throw new ObjectNotFoundException('Forum', $command->forumId);
        }

        $subject = new Subject(
            title: $command->title,
            forum: $forum
        );

        $this->subjects->add($subject);
        $this->eventLog->record(new Event\Created($subject));

        return $subject;
    }
}
