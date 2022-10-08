<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Application\Synchronization\Push;

final class PushNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Push;
    }

    /**
     * {@inheritDoc}
     *
     * @param Push $data
     */
    public function normalize(mixed $data): array
    {
        return [
            'type' => $data->getType()->value,
            'context' => $data->getContext(),
            'identifier' => $data->getIdentifier(),
            'payload' => $data->getPayload()
        ];
    }
}
