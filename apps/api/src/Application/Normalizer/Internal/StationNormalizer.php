<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Domain\Model\Channel;
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
     *
     * @return array<string,array<array<string,string>>|string|null>
     */
    public function normalize(mixed $data): array
    {
        return [
            'id'   => (string) $data->getIdentifier(),
            'name' => $data->getName(),
            'description' => $data->getDescription(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d'),
            'channels' => array_map(
                fn (Channel $channel): array => [
                    'id' => (string) $channel->getIdentifier(),
                    'name' => $channel->getName()
                ],
                $data->getChannels()
            )
        ];
    }
}
