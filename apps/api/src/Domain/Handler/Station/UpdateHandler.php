<?php

declare(strict_types=1);

namespace Domain\Handler\Station;

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler;
use Domain\Message\Station as Message;
use Domain\Model\Station;
use Domain\Repository\Stations;

final class UpdateHandler implements Handler
{
    public function __construct(private Stations $stations)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Update;
    }

    public function __invoke(Message\Update $message): Station
    {
        if (!$station = $this->stations->find($message->getIdentifier())) {
            throw new ObjectNotFoundException('Station', (string) $message->getIdentifier());
        }

        if (null !== $this->stations->findByName($message->getName())) {
            throw new ObjectAlreadyExistsException('Station', $message->getName());
        }

        $station->setName($message->getName());
        $station->setDescription($message->getDescription());

        return $station;
    }
}
