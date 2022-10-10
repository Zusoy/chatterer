<?php

namespace Application\Normalizer;

use Application\Normalizer\Exception\NormalizerNotFoundException;

interface Normalizer
{
    public function supports(mixed $data): bool;

    /**
     * @return mixed
     *
     * @throws NormalizerNotFoundException
     */
    public function normalize(mixed $data): mixed;
}
