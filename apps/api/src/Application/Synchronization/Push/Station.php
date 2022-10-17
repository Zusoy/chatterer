<?php

namespace Application\Synchronization\Push;

use Application\Synchronization\Push;
use Application\Synchronization\Type;
use Domain\Model;

final class Station extends Push
{
    private const CONTEXT = 'station';

    public static function insert(Model\Station $station): Push
    {
        return new self(Type::INSERT, self::CONTEXT, $station->getIdentifier(), $station);
    }

    public static function update(Model\Station $station): Push
    {
        return new self(Type::UPDATE, self::CONTEXT, $station->getIdentifier(), $station);
    }

    public static function delete(Model\Station $station): Push
    {
        return new self(Type::DELETE, self::CONTEXT, $station->getIdentifier());
    }
}
