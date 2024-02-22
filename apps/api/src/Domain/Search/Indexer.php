<?php

declare(strict_types=1);

namespace Domain\Search;

use Domain\Model\Message;

interface Indexer
{
    public function upsert(Message $message): void;

    public function remove(Message $message): void;

    public function prune(): void;
}
