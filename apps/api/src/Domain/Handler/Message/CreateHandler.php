<?php

declare(strict_types=1);

namespace Domain\Handler\Message;

use Domain\Event\Message as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Message as Message;
use Domain\Model;
use Domain\Repository\Channels;
use Domain\Repository\Messages;
use Domain\Repository\Users;

final class CreateHandler implements Handler
{
    public function __construct(
        private Users $users,
        private Channels $channels,
        private Messages $messages,
        private EventLog $eventLog
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Create;
    }

    public function __invoke(Message\Create $message): Model\Message
    {
        if (!$author = $this->users->find($message->getAuthorId())) {
            throw new ObjectNotFoundException('User', (string) $message->getAuthorId());
        }

        if (!$channel = $this->channels->find($message->getChannelId())) {
            throw new ObjectNotFoundException('Channel', (string) $message->getChannelId());
        }

        $newMessage = new Model\Message(
            author: $author,
            content: $message->getContent(),
            channel: $channel
        );

        $this->messages->add($newMessage);
        $this->eventLog->record(new Event\Created($newMessage));

        return $newMessage;
    }
}
