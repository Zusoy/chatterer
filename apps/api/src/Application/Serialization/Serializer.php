<?php

declare(strict_types=1);

namespace Application\Serialization;

interface Serializer
{
    public const JSON_FORMAT = 'json';

    public function supports(mixed $data, string $format): bool;

    public function serialize(mixed $data, string $format): mixed;
}
