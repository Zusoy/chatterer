<?php

namespace Application\Messaging;

use Application\Messaging\Map\HandlerMap;
use Application\Messaging\Transaction\Transaction;
use Domain\Bus;
use Domain\Message;
use Throwable;

final class TransactionalMessageBus implements Bus
{
    public function __construct(private HandlerMap $handlers, private Transaction $transaction)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Message $message): mixed
    {
        $handler = $this->handlers->getHandler($message);

        try {
            $this->transaction->begin();

            $output = ($handler)($message);
        } catch (Throwable $error) {
            $this->transaction->rollback();

            throw $error;
        }

        $this->transaction->commit();

        return $output;
    }
}
