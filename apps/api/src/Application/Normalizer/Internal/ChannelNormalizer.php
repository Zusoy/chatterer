<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Domain\Model\Channel;

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
    public function normalize(mixed $data): array
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
