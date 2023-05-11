<?php

declare(strict_types=1);

namespace Domain\CommandHandler\Config;

use Domain\Command\Config as Command;

final class GetHandler
{
    public function __construct(private readonly string $apiURL)
    {
    }

    /**
     * @return array<string,string>
     */
    public function __invoke(Command\Get $command): array
    {
        return [
            'apiUrl' => $this->apiURL
        ];
    }
}
