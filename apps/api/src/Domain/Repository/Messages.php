<?php

namespace Domain\Repository;

use Domain\Model\Message;

interface Messages
{
    public function add(Message $message): void;
}
