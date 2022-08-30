<?php

namespace Application\Normalizer;

use Application\Normalizer\Exception\NormalizerNotFoundException;

interface Normalizer
{
    public function supports(mixed $data): bool;

    /**
     * @return array<string,mixed>
     *
     * @throws NormalizerNotFoundException
     */
    public function normalize(mixed $data): array;
}
