<?php

namespace Application\Serializer;

use Application\Serializer\Exception\SerializerNotFoundException;

interface Serializer
{
    public const JSON_FORMAT = 'json';

    public function supports(mixed $data, string $format): bool;

    /**
     * @throws SerializerNotFoundException
     */
    public function serialize(mixed $data, string $format): mixed;
}
