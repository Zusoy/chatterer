<?php

namespace Application\Messaging;

use Application\Messaging\Map\HandlerMap;
use Application\Messaging\Trace\MessageTrace;
use Application\Messaging\Transaction\Transaction;
use Domain\Bus;
use Domain\Message;
use Throwable;

final class TraceableMessageBus implements Bus
{
    /**
     * @var MessageTrace[]
     */
    private array $executedMessages = [];

    public function __construct(private HandlerMap $handlers, private Transaction $transaction)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Message $message): mixed
    {
        $handler = $this->handlers->getHandler($message);
        $trace = new MessageTrace($message, $handler, microtime(true));

        try {
            $this->transaction->begin();

            $output = ($handler)($message);
        } catch (Throwable $error) {
            $this->transaction->rollback();

            throw $error;
        } finally {
            $this->executedMessages[] = $trace;
        }

        $this->transaction->commit();

        return $output;
    }

    /**
     * @return MessageTrace[]
     */
    public function getExecutedMessages(): array
    {
        return $this->executedMessages;
    }
}
