<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Exception\NormalizerNotFoundException;
use Application\Normalization\Normalizer;

/**
 * @template T
 *
 * @implements Normalizer<T>
 */
final class AggregateNormalizer implements Normalizer
{
    /**
     * @param iterable<Normalizer<T>> $normalizers
     */
    public function __construct(private readonly iterable $normalizers)
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
    public function normalize(mixed $data): mixed
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

        throw new NormalizerNotFoundException(gettype($data));
    }

    /**
     * @param T $data
     *
     * @return Normalizer<T>|null
     */
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
