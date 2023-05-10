<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Application\Synchronization\Push;

/**
 * @template T
 *
 * @implements Normalizer<Push<T>>
 */
final class PushNormalizer implements Normalizer
{
    /**
     * @param Normalizer<T> $normalizer
     */
    public function __construct(private readonly Normalizer $normalizer)
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
    public function normalize(mixed $data): mixed
    {
        $pushPayload = $data->getPayload();

        /** @var T|null */
        $payload = $pushPayload ? $this->normalizer->normalize($pushPayload) : null;

        return [
            'type' => $data->getType()->value,
            'context' => $data->getContext(),
            'identifier' => $data->getIdentifier(),
            'payload' => $payload
        ];
    }
}
