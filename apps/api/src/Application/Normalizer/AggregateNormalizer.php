<?php

namespace Application\Normalizer;

use Application\Normalizer\Exception\NormalizerNotFoundException;

final class AggregateNormalizer implements Normalizer
{
    /**
     * @param iterable<Normalizer> $normalizers
     */
    public function __construct(private iterable $normalizers)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function normalize(mixed $data): array
    {
        if ($normalizer = $this->findNormalizer($data)) {
            return $normalizer->normalize($data);
        }

        if (null === $data || is_scalar($data)) {
            return $data;
        }

        if (is_array($data) && count($data) === 0) {
            return [];
        }

        if (is_iterable($data)) {
            $normalized = [];

            foreach ($data as $key => $val) {
                $normalized[$key] = $this->normalize($val);
            }

            return $normalized;
        }

        throw new NormalizerNotFoundException(get_class($data));
    }

    private function findNormalizer(mixed $data): ?Normalizer
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($data)) {
                return $normalizer;
            }
        }

        return null;
    }
}
