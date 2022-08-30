<?php

namespace Application\Serializer\Internal;

use Application\Serializer\Serializer;

final class JsonSerializer implements Serializer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data, string $format): bool
    {
        return $format === Serializer::JSON_FORMAT;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(mixed $data, string $format): mixed
    {
        return json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}
