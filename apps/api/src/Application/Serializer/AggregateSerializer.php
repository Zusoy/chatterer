<?php

namespace Application\Serializer;

use Application\Serializer\Exception\SerializerNotFoundException;

final class AggregateSerializer implements Serializer
{
    /**
     * @param iterable<Serializer> $serializers
     */
    public function __construct(private iterable $serializers)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data, string $format): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(mixed $data, string $format): mixed
    {
        if ($serializer = $this->findSerializer($data, $format)) {
            return $serializer->serialize($data, $format);
        }

        if (null === $data || is_scalar($data)) {
            return $data;
        }

        if (is_iterable($data)) {
            $serialized = [];

            foreach ($data as $key => $val) {
                $serialized[$key] = $this->serialize($val, $format);
            }

            return $serialized;
        }

        throw new SerializerNotFoundException($format);
    }

    private function findSerializer(mixed $data, string $format): ?Serializer
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->supports($data, $format)) {
                return $serializer;
            }
        }

        return null;
    }
}
