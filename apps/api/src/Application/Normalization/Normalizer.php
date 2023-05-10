<?php

namespace Application\Normalization;

/**
 * @template T
 */
interface Normalizer
{
    /**
     * @param T $data
     */
    public function supports(mixed $data): bool;

    /**
     * @param T $data
     */
    public function normalize(mixed $data): mixed;
}
