<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Domain\Model\Station;

final class StationNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Station;
    }

    /**
     * {@inheritDoc}
     *
     * @param Station $data
     */
    public function normalize(mixed $data): array
    {
        return [
            'id'   => (string) $data->getId(),
            'name' => $data->getName()
        ];
    }
}
