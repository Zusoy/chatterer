<?php

namespace Infra\Faker;

use Domain\Security\PasswordHasher;
use Faker\Factory as BaseFactory;
use Faker\Generator;
use Infra\Faker\Provider\DomainProvider;

final class Factory
{
    public const DEFAULT_LOCALE = 'fr_FR';

    public function __construct(private PasswordHasher $passwordHasher)
    {
    }

    public function create(string $locale = self::DEFAULT_LOCALE): Generator
    {
        $generator = BaseFactory::create($locale);

        $generator->addProvider(new DomainProvider($generator, $this->passwordHasher));

        return $generator;
    }
}
