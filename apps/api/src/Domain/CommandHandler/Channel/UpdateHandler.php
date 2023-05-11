<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Channel;

use Domain\Command\Channel as Command;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Channel;
use Domain\Repository\Channels;

final class UpdateHandler
{
    public function __construct(private readonly Channels $channels)
    {
    }

    public function __invoke(Command\Update $command): Channel
    {
        if (!$channel = $this->channels->find($command->getIdentifier())) {
            throw new ObjectNotFoundException('Channel', (string) $command->getIdentifier());
        }

        if (null !== $this->channels->findByName($channel->getStationIdentifier(), $command->name)) {
            throw new ObjectAlreadyExistsException('Channel', $command->name);
        }

        $channel->setName($command->name);
        $channel->setDescription($command->description);

        return $channel;
    }
}
