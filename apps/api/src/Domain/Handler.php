<?php

declare(strict_types=1);

namespace Domain;

use Domain\Message;

interface Handler
{
    /**
     * Checks the handler supports
     */
    public function supports(Message $message): bool;
}
