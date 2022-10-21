<?php

namespace Application\Synchronization\Hub;

use Application\Synchronization\Hub;
use Application\Synchronization\Push;

/**
 * @template T
 */
final class MockedHub implements Hub
{
    /**
     * @var Push<T>[]
     */
    private array $queue;

    /**
     * @var Push<T>[]
     */
    private array $sentPushes;

    public function __construct()
    {
        $this->clean();
    }

    /**
     * @return Push<T>[]
     */
    public function getQueue(): array
    {
        return $this->queue;
    }

    /**
     * @return Push<T>[]
     */
    public function getSentPushes(): array
    {
        return $this->sentPushes;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublicUrl(): string
    {
        return 'http://mocked.hub';
    }

    /**
     * {@inheritDoc}
     *
     * @param Push<T> $push
     */
    public function push(Push $push): void
    {
        $this->queue[] = $push;
    }

    /**
     * {@inheritDoc}
     */
    public function send(): void
    {
        $this->sentPushes = array_merge(
            $this->sentPushes,
            array_splice($this->queue, 0)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getUriForTopic(string $topic): string
    {
        return "mocked://$topic";
    }

    public function clean(): void
    {
        $this->queue = [];
        $this->sentPushes = [];
    }
}
