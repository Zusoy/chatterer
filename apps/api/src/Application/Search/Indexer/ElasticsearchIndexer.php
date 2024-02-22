<?php

declare(strict_types=1);

namespace Application\Search\Indexer;

use Domain\Model\Message;
use Domain\Search\Indexer;
use Elastic\Elasticsearch\Client;

final class ElasticsearchIndexer implements Indexer
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function upsert(Message $message): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Message $message): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function prune(): void
    {
    }
}
