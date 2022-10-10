<?php

namespace Domain\Handler\Channel;

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Model\Channel;
use Domain\Repository\Channels;
use Domain\Repository\Stations;

final class CreateHandler implements Handler
{
    public function __construct(private Stations $stations, private Channels $channels)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Create;
    }

    public function __invoke(Message\Create $message): Channel
    {
        if (!$station = $this->stations->find($message->getStationId())) {
            throw new ObjectNotFoundException('Station', $message->getStationId());
        }

        if (null !== $this->channels->findByName($station->getIdentifier(), $message->getName())) {
            throw new ObjectAlreadyExistsException('Channel', $message->getName());
        }

        $channel = new Channel(
            $station,
            $message->getName(),
            $message->getDescription()
        );

        $this->channels->add($channel);

        return $channel;
    }
}
