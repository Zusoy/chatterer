<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Domain\Model\Invitation;

/**
 * @implements Normalizer<Invitation>
 */
final class InvitationNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Invitation;
    }

    /**
     * {@inheritDoc}
     *
     * @param Invitation $data
     *
     * @return array<string>
     */
    public function normalize(mixed $data): mixed
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'station' => (string) $data->getStationIdentifier(),
            'token' => (string) $data->getToken(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d')
        ];
    }
}
