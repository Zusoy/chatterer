<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Domain\Model\Message;

/**
 * @implements Normalizer<Message>
 */
final class MessageNormalizer implements Normalizer
{
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
    public function normalize(mixed $data): mixed
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'content' => $data->getContent(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d'),
            'channel' => [
                'id' => (string) $data->getChannelIdentifier(),
                'name' => $data->getChannelName()
            ],
            'author' => [
                'id' => (string) $data->getAuthorIdentifier(),
                'name' => $data->getAuthorName()
            ]
        ];
    }
}
