<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Message;

interface Messages
{
    public function add(Message $message): void;

    public function find(Identifier $identifier): ?Message;

    /**
     * @return iterable<Message>
     */
    public function findAll(Channel $channel): iterable;

    public function remove(Message $message): void;
}
