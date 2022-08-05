<?php

namespace Domain\Message;

use Domain\Message;

class Test implements Message
{
    public function __construct(private string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
