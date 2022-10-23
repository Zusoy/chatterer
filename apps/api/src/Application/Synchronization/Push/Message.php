<?php

namespace Application\Synchronization\Push;

use Application\Synchronization\Exception\MissingPayloadException;
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

    public static function delete(Model\Message $message): self
    {
        return new self(Type::DELETE, self::CONTEXT, $message->getIdentifier(), $message);
    }

    /**
     * {@inheritDoc}
     */
    public function getTopics(): array
    {
        if (!$payload = $this->getPayload()) {
            throw new MissingPayloadException(self::CONTEXT);
        }

        return ["$this->context/list/{$payload->getChannelIdentifier()}"];
    }
}
