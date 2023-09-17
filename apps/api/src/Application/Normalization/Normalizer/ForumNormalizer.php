<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Domain\Model\Forum\Forum;

/**
 * @implements Normalizer<Forum>
 */
final class ForumNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Forum;
    }

    /**
     * {@inheritDoc}
     *
     * @param Forum $data
     *
     * @return array<string,string|array<string,string>>
     */
    public function normalize(mixed $data): mixed
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'name' => $data->getName(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d'),
            'station' => [
                'id' => (string) $data->getStationIdentifier(),
                'name' => $data->getStationName()
            ]
        ];
    }
}
