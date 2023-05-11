<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Channel;

use Domain\Command\Channel as Command;
use Domain\Event\Channel as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\UserAlreadyJoinedException;
use Domain\Model\Channel;
use Domain\Repository\Channels;
use Domain\Repository\Users;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class JoinHandler
{
    public function __construct(
        private readonly Channels $channels,
        private readonly Users $users,
        private readonly AccessControl $accessControl,
        private readonly EventLog $eventLog
    ) {
    }

    public function __invoke(Command\Join $command): Channel
    {
        if (!$channel = $this->channels->find($command->getChannelIdentifier())) {
            throw new ObjectNotFoundException('Channel', (string) $command->getChannelIdentifier());
        }

        if (!$user = $this->users->find($command->getUserIdentifier())) {
            throw new ObjectNotFoundException('User', (string) $command->getUserIdentifier());
        }

        $this->accessControl->requires(
            operation: Operation::JOIN_CHANNEL,
            context: ['channel' => $channel],
            user: $user
        );

        if ($channel->has($user)) {
            throw new UserAlreadyJoinedException($channel, $user);
        }

        $user->joinChannel($channel);
        $this->eventLog->record(new Event\NewMember($channel, $user));

        return $channel;
    }
}
