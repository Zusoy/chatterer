<?php

namespace Application\Messaging\Map;

use Application\Messaging\Exception\HandlerNotFoundException;
use Domain\Handler;
use Domain\Message;

interface HandlerMap
{
    /**
     * @throws HandlerNotFoundException
     */
    public function getHandler(Message $message): Handler;
}