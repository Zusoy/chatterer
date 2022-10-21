<?php

namespace Application\Synchronization\Push;

use Application\Synchronization\Exception\MissingPayloadException;
use Application\Synchronization\Push;
use Application\Synchronization\Type;
use Domain\Model;

/**
 * @extends Push<Model\Channel>
 */
final class Channel extends Push
{
    private const CONTEXT = 'channel';

    public static function insert(Model\Channel $channel): self
    {
        return new self(Type::INSERT, self::CONTEXT, $channel->getIdentifier(), $channel);
    }

    public static function update(Model\Channel $channel): self
    {
        return new self(Type::UPDATE, self::CONTEXT, $channel->getIdentifier(), $channel);
    }

    public static function delete(Model\Channel $channel): self
    {
        return new self(Type::DELETE, self::CONTEXT, $channel->getIdentifier(), $channel);
    }

    /**
     * {@inheritDoc}
     */
    public function getTopics(): array
    {
        if (!$payload = $this->getPayload()) {
            throw new MissingPayloadException(self::CONTEXT);
        }

        return ["$this->context/list/{$payload->getStationIdentifier()}"];
    }
}
