<?php

namespace Application\Synchronization;

interface Hub
{
    public function getPublicUrl(): string;

    public function push(Push $push): void;

    public function send();

    public function getUriForTopic(string $topic): string;
}
