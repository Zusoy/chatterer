<?php

declare(strict_types=1);

namespace Domain\Handler\Channel;

use Domain\Event\Channel as Event;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\UserAlreadyJoinedException;
use Domain\Handler;
use Domain\Message\Channel as Message;
use Domain\Model\Channel;
use Domain\Repository\Channels;
use Domain\Repository\Users;
use Domain\Security\AccessControl;
use Domain\Security\Operation;

final class JoinHandler implements Handler
{
    public function __construct(
        private Channels $channels,
        private Users $users,
        private AccessControl $accessControl,
        private EventLog $eventLog
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Join;
    }

    public function __invoke(Message\Join $message): Channel
    {
        if (!$channel = $this->channels->find($message->getChannelIdentifier())) {
            throw new ObjectNotFoundException('Channel', (string) $message->getChannelIdentifier());
        }

        if (!$user = $this->users->find($message->getUserIdentifier())) {
            throw new ObjectNotFoundException('User', (string) $message->getUserIdentifier());
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
