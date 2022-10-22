<?php

namespace Domain\Repository;

use Domain\Identity\Identifier;
use Domain\Model\Message;

interface Messages
{
    public function add(Message $message): void;

    public function find(Identifier $identifier): ?Message;

    public function remove(Message $message): void;
}
