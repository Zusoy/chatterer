<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Domain\Model\Channel;

/**
 * @implements Normalizer<Channel>
 */
final class ChannelNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Channel;
    }

    /**
     * {@inheritDoc}
     *
     * @param Channel $data
     *
     * @return array<string,string|array<string,string>|null>
     */
    public function normalize(mixed $data): mixed
    {
        return [
            'id'   => (string) $data->getIdentifier(),
            'name' => $data->getName(),
            'description' => $data->getDescription(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d'),
            'station' => [
                'id' => (string) $data->getStationIdentifier(),
                'name' => $data->getStationName()
            ]
        ];
    }
}
