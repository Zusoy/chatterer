<?php

namespace Application\Messaging\Trace;

use Domain\Handler;
use Domain\Message;

final class MessageTrace
{
    public function __construct(
        private Message $message,
        private Handler $handler,
        private float $callTime
    ) {
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getMessageName(): string
    {
        return get_class($this->message);
    }

    public function getHandler(): Handler
    {
        return $this->handler;
    }

    public function getHandlerName(): string
    {
        return get_class($this->handler);
    }

    public function getCallTime(): float
    {
        return $this->callTime;
    }
}
