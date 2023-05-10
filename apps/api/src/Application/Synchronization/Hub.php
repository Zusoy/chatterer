<?php

declare(strict_types=1);

namespace Application\Synchronization;

interface Hub
{
    public function getPublicUrl(): string;

    /**
     * @template T
     *
     * @param Push<T> $push
     */
    public function push(Push $push): void;

    public function send(): void;

    public function getUriForTopic(string $topic): string;
}
