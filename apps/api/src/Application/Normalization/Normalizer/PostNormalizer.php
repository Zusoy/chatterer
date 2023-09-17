<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Domain\Model\Forum\Post;

/**
 * @implements Normalizer<Post>
 */
final class PostNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Post;
    }

    /**
     * {@inheritDoc}
     *
     * @param Post $data
     *
     * @return array<string,string|array<string,string>>
     */
    public function normalize(mixed $data): mixed
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'content' => $data->getContent(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d'),
            'author' => [
                'id' => (string) $data->getAuthorIdentifier(),
                'name' => $data->getAuthorName()
            ],
            'subject' => [
                'id' => (string) $data->getSubjectIdentifier(),
                'title' => $data->getSubjectTitle()
            ]
        ];
    }
}
