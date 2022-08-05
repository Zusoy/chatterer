<?php

namespace Infra\Framework\HttpKernel\DataCollector;

use Application\Messaging\Trace\MessageTrace;
use Application\Messaging\TraceableMessageBus;
use Domain\Bus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;
use Throwable;

final class MessengerDataCollector extends DataCollector implements DataCollectorInterface, LateDataCollectorInterface
{
    private const ID = 'messenger';

    public function __construct(private Bus $bus)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function collect(Request $request, Response $response, ?Throwable $exception = null): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function lateCollect(): void
    {
        // in development environment the bus should be traceable
        if (!$this->bus instanceof TraceableMessageBus) {
            return;
        }

        $this->data = $this->bus->getExecutedMessages();
    }

    /**
     * {@inheritDoc}
     */
    public function reset(): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return self::ID;
    }

    /**
     * @return MessageTrace[]
     */
    public function getData(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->data;
    }
}
