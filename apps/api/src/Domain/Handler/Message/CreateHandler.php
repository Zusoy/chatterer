<?php

namespace Domain\Handler\Message;

use Domain\Event\Message as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Message as Message;
use Domain\Model;
use Domain\Repository\Channels;
use Domain\Repository\Messages;

final class CreateHandler implements Handler
{
    public function __construct(
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
        if (!$channel = $this->channels->find($message->getChannelId())) {
            throw new ObjectNotFoundException('Channel', $message->getChannelId());
        }

        $newMessage = new Model\Message(
            content: $message->getContent(),
            channel: $channel
        );

        $this->messages->add($newMessage);
        $this->eventLog->record(new Event\Created($newMessage));

        return $newMessage;
    }
}
