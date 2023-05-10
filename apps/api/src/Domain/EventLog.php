<?php

declare(strict_types=1);

namespace Domain;

interface EventLog
{
    public function record(Event $event): void;
}
