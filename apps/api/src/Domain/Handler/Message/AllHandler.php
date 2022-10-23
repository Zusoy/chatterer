<?php

namespace Domain\Handler\Message;

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Message as Message;
use Domain\Model;
use Domain\Repository\Channels;
use Domain\Repository\Messages;

final class AllHandler implements Handler
{
    public function __construct(private Channels $channels, private Messages $messages)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\All;
    }

    /**
     * @return iterable<Model\Message>
     */
    public function __invoke(Message\All $message): iterable
    {
        if (!$channel = $this->channels->find($message->getChannelId())) {
            throw new ObjectNotFoundException('Channel', $message->getChannelId());
        }

        return $this->messages->findAll($channel);
    }
}
