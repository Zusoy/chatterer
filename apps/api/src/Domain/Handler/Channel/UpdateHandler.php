<?php

namespace Domain\Handler\Channel;

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Model\Channel;
use Domain\Repository\Channels;

final class UpdateHandler implements Handler
{
    public function __construct(private Channels $channels)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Update;
    }

    public function __invoke(Message\Update $message): Channel
    {
        if (!$channel = $this->channels->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Channel', $message->getIdentifier());
        }

        if (null !== $this->channels->findByName($channel->getStationIdentifier(), $message->getName())) {
            throw new ObjectAlreadyExistsException('Channel', $message->getName());
        }

        $channel->setName($message->getName());
        $channel->setDescription($message->getDescription());

        return $channel;
    }
}
