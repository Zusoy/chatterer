<?php

declare(strict_types=1);

namespace Application\Search\Indexer;

use Domain\Model\Message;
use Domain\Search\Indexer;

final class MockedIndexer implements Indexer
{
    /**
     * @var string[]
     */
    private array $index = [];

    public function __construct()
    {
    }

    /**
     * @return string[]
     */
    public function getCurrentIndex(): array
    {
        return $this->index;
    }

    /**
     * {@inheritDoc}
     */
    public function upsert(Message $message): void
    {
        $this->index[] = (string) $message->getIdentifier();
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Message $message): void
    {
        $messageId = (string) $message->getIdentifier();

        $this->index = array_filter(
            $this->index,
            static fn (string $id): bool => $id !== $messageId
        );
    }

    /**
     * {@inheritDoc}
     */
    public function prune(): void
    {
        $this->index = [];
    }
}
