<?php

namespace Application\Messaging\Map;

use Application\Messaging\Exception\HandlerNotFoundException;
use Domain\Message;
use Domain\Handler;
use Assert\Assert;

final class InMemoryHandlerMap implements HandlerMap
{
    /**
     * @param iterable<Handler> $handlers
     */
    public function __construct(private iterable $handlers = [])
    {
        Assert::thatAll($handlers, defaultPropertyPath: 'handlers')->isCallable();
    }

    /**
     * {@inheritDoc}
     */
    public function getHandler(Message $message): Handler
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($message)) {
                return $handler;
            }
        }

        throw new HandlerNotFoundException(get_class($message));
    }
}
