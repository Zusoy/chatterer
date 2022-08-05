<?php

namespace Application\Messaging\Trace;

use Domain\Handler;
use Domain\Message;

final class MessageTrace
{
    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(
        private Message $message,
        private Handler $handler,
        private float $callTime,
        private array $parameters = []
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

    /**
     * @return array<string,mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getCallTime(): float
    {
        return $this->callTime;
    }
}
