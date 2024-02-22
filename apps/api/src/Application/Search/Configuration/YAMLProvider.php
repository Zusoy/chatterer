<?php

declare(strict_types=1);

namespace Application\Search\Configuration;

use Symfony\Component\Yaml\Yaml;

final class YAMLProvider implements Provider
{
    public function __construct(private readonly string $filePath)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {
        $config = Yaml::parseFile($this->filePath);

        return $config;
    }
}
