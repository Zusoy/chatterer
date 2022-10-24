<?php

namespace Infra\Faker;

use Faker\Factory as BaseFactory;
use Faker\Generator;
use Infra\Faker\Provider\DomainProvider;

final class Factory
{
    public const DEFAULT_LOCALE = 'fr_FR';

    public function create(string $locale = self::DEFAULT_LOCALE): Generator
    {
        $generator = BaseFactory::create($locale);

        $generator->addProvider(new DomainProvider($generator));

        return $generator;
    }
}
