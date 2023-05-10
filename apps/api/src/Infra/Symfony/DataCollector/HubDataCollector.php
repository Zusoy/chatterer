<?php

namespace Infra\Symfony\DataCollector;

use Symfony\Bundle\MercureBundle\DataCollector\MercureDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;
use Symfony\Component\Mercure\Debug\TraceableHub;
use Throwable;

final class HubDataCollector implements LateDataCollectorInterface, DataCollectorInterface
{
    public function __construct(private MercureDataCollector $innerCollector)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, Throwable $exception = null): void
    {
        $this->innerCollector->collect($request, $response, $exception);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->innerCollector->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): void
    {
        $this->innerCollector->reset();
    }

    /**
     * {@inheritdoc}
     */
    public function lateCollect(): void
    {
        // passing dummy values to avoid errors (these are not used in the inner collector anyway)
        $this->innerCollector->collect(new Request(), new Response());
    }

    public function count(): int
    {
        return $this->innerCollector->count();
    }

    public function getDuration(): float
    {
        return $this->innerCollector->getDuration();
    }

    public function getMemory(): int
    {
        return $this->innerCollector->getMemory();
    }

    /**
     * @return iterable<TraceableHub>
     */
    public function getHubs(): iterable
    {
        return $this->innerCollector->getHubs();
    }
}
