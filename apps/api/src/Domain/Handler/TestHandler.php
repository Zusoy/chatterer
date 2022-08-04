<?php

namespace Domain\Handler;

use Domain\Handler;
use Domain\Message;
use Domain\Message\Test;

final class TestHandler implements Handler
{
    public function supports(Message $message): bool
    {
        return $message instanceof Test;
    }

    public function __invoke(Test $message): string
    {
        return strtoupper($message->getMessage());
    }
}
