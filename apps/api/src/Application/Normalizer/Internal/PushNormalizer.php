<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Application\Synchronization\Push;

/**
 * @template T
 */
final class PushNormalizer implements Normalizer
{
    public function __construct(private Normalizer $normalizer)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Push;
    }

    /**
     * {@inheritDoc}
     *
     * @param Push<T> $data
     *
     * @return array<string,string|mixed>
     */
    public function normalize(mixed $data): array
    {
        $payload = $this->normalizer->normalize($data->getPayload());

        return [
            'type' => $data->getType()->value,
            'context' => $data->getContext(),
            'identifier' => $data->getIdentifier(),
            'payload' => $payload
        ];
    }
}
