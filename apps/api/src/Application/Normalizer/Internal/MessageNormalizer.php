<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Domain\Model\Message;

final class MessageNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Message;
    }

    /**
     * {@inheritDoc}
     *
     * @param Message $data
     *
     * @return array<string,string|array<string,string>|null>
     */
    public function normalize(mixed $data): array
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'content' => $data->getContent(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d'),
            'channel' => [
                'id' => (string) $data->getChannelIdentifier(),
                'name' => $data->getChannelName()
            ]
        ];
    }
}
