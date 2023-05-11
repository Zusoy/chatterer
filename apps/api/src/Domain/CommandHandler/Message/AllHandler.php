<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Message;

use Domain\Command\Message as Command;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model;
use Domain\Repository\Channels;
use Domain\Repository\Messages;

final class AllHandler
{
    public function __construct(
        private readonly Channels $channels,
        private readonly Messages $messages
    ) {
    }

    /**
     * @return iterable<Model\Message>
     */
    public function __invoke(Command\All $command): iterable
    {
        if (!$channel = $this->channels->find($command->getChannelId())) {
            throw new ObjectNotFoundException('Channel', (string) $command->getChannelId());
        }

        return $this->messages->findAll($channel);
    }
}
