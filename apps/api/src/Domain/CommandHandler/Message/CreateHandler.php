<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Message;

use Domain\Command\Message as Command;
use Domain\Event\Message as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model;
use Domain\Repository\Channels;
use Domain\Repository\Messages;
use Domain\Repository\Users;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class CreateHandler
{
    public function __construct(
        private readonly AccessControl $accessControl,
        private readonly Users $users,
        private readonly Channels $channels,
        private readonly Messages $messages,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Create $command): Model\Message
    {
        if (!$author = $this->users->find($command->getAuthorId())) {
            throw new ObjectNotFoundException('User', (string) $command->getAuthorId());
        }

        if (!$channel = $this->channels->find($command->getChannelId())) {
            throw new ObjectNotFoundException('Channel', (string) $command->getChannelId());
        }

        $this->accessControl->requires(Operation::CREATE_MESSAGE, context: ['channel' => $channel]);

        $newMessage = new Model\Message(
            author: $author,
            content: $command->content,
            channel: $channel
        );

        $this->messages->add($newMessage);
        $this->eventLog->record(new Event\Created($newMessage));

        return $newMessage;
    }
}
