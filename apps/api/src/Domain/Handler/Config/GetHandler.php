<?php

declare(strict_types=1);

namespace Domain\Handler\Config;

use Domain\Message\Config as Message;
use Domain\Handler;

final class GetHandler implements Handler
{
    public function __construct(private string $apiURL)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(\Domain\Message $message): bool
    {
        return $message instanceof Message\Get;
    }

    /**
     * @return array<string,string>
     */
    public function __invoke(Message\Get $message): array
    {
        return [
            'apiUrl' => $this->apiURL
        ];
    }
}
