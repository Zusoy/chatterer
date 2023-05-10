<?php

declare(strict_types=1);

namespace Application\Synchronization\Push;

use Application\Synchronization\Push;
use Application\Synchronization\Type;
use Domain\Model;

/**
 * @extends Push<Model\Station>
 */
final class Station extends Push
{
    private const CONTEXT = 'station';

    public static function insert(Model\Station $station): self
    {
        return new self(Type::INSERT, self::CONTEXT, (string) $station->getIdentifier(), $station);
    }

    public static function update(Model\Station $station): self
    {
        return new self(Type::UPDATE, self::CONTEXT, (string) $station->getIdentifier(), $station);
    }

    public static function delete(Model\Station $station): self
    {
        return new self(Type::DELETE, self::CONTEXT, (string) $station->getIdentifier());
    }
}
