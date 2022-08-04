<?php

namespace Domain;

use Domain\Message;

interface Handler
{
    public function supports(Message $message): bool;
}
