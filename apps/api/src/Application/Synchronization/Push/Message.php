<?php

namespace Application\Synchronization\Push;

use Application\Synchronization\Push;
use Application\Synchronization\Type;
use Domain\Model;

/**
 * @extends Push<Model\Message>
 */
final class Message extends Push
{
    private const CONTEXT = 'message';

    public static function insert(Model\Message $message): self
    {
        return new self(Type::INSERT, self::CONTEXT, $message->getIdentifier(), $message);
    }
}
