<?php

declare(strict_types=1);

namespace Application\Messaging;

use Application\Messaging\Map\HandlerMap;
use Application\Messaging\Trace\MessageTrace;
use Application\Messaging\Transaction\Transaction;
use Assert\Assert;
use Domain\Bus;
use Domain\Message;
use ReflectionClass;
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
        Assert::that($handler)->isCallable();

        $trace = new MessageTrace(
            message: $message,
            handler: $handler,
            parameters: $this->extractParameters($message),
            callTime: microtime(true)
        );

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

    /**
     * @return array<string,mixed>
     */
    private function extractParameters(Message $message): array
    {
        $parameters = [];
        $reflection = new ReflectionClass($message);

        foreach ($reflection->getProperties() as $property) {
            $parameters[$property->getName()] = $property->getValue($message);
        }

        return $parameters;
    }
}
