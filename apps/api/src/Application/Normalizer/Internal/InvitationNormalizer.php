<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Domain\Model\Invitation;

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
     */
    public function normalize(mixed $data): mixed
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'station' => (string) $data->getStationIdentifier(),
            'token' => (string) $data->getToken()
        ];
    }
}
