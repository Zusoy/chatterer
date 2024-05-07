<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Domain\Model\Forum\Subject;

/**
 * @implements Normalizer<Subject>
 */
final class SubjectNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $data): bool
    {
        return $data instanceof Subject;
    }

    /**
     * {@inheritDoc}
     *
     * @param Subject $data
     *
     * @return array<string,string|array<string,string>>
     */
    public function normalize(mixed $data): mixed
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'title' => $data->getTitle(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d'),
            'forum' => [
                'id' => (string) $data->getForumIdentifier(),
                'name' => $data->getForumName()
            ]
        ];
    }
}
