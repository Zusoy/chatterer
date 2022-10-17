<?php

namespace Domain\Handler\Channel;

use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Repository\Channels;

final class DeleteHandler implements Handler
{
    public function __construct(private Channels $channels)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Delete;
    }

    public function __invoke(Message\Delete $message): void
    {
        if (!$channel = $this->channels->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Channel', $message->getIdentifier());
        }

        $this->channels->remove($channel);
    }
}
