<?php

namespace Application\Normalizer\Internal;

use Application\Normalizer\Normalizer;
use Domain\Model\User;

final class UserNormalizer implements Normalizer
{
    /**
     * {@inheritDoc}
     */
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
