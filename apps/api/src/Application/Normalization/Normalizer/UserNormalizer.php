<?php

declare(strict_types=1);

namespace Application\Normalization\Normalizer;

use Application\Normalization\Normalizer;
use Domain\Model\User;

/**
 * @implements Normalizer<User>
 */
final class UserNormalizer implements Normalizer
{
    public function supports(mixed $data): bool
    {
        return $data instanceof User;
    }

    /**
     * {@inheritDoc}
     *
     * @param User $data
     *
     * @return array<string,string|bool>
     */
    public function normalize(mixed $data): mixed
    {
        return [
            'id' => (string) $data->getIdentifier(),
            'firstname' => $data->getFirstname(),
            'lastname' => $data->getLastname(),
            'email' => $data->getEmail(),
            'isAdmin' => $data->isAdmin(),
            'createdAt' => $data->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $data->getUpdatedAt()->format('Y-m-d')
        ];
    }
}
