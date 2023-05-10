<?php

declare(strict_types=1);

namespace Application\Messaging;

use Application\Messaging\Map\HandlerMap;
use Application\Messaging\Transaction\Transaction;
use Assert\Assert;
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
        Assert::that($handler)->isCallable();

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
