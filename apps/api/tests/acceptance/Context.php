<?php

declare(strict_types=1);

namespace Test\Acceptance;

use Behat\Behat\Context\Context as BehatContext;
use Faker\Generator;
use Faker\Factory;

abstract class Context implements BehatContext
{
    protected Generator $faker;

    /**
     * @var Helper[]
     */
    private array $helpers = [];

    public function __construct(
        protected readonly Helper\Http $http,
        protected readonly Helper\Database $database,
        protected readonly Helper\Schema $schema,
    ) {
        $this->faker = Factory::create(Factory::DEFAULT_LOCALE);

        $this->helpers = array_filter(
            \func_get_args(),
            static fn (mixed $arg): bool => $arg instanceof Helper,
        );
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenarioForAllHelpers(): void
    {
        array_walk(
            $this->helpers,
            static fn (Helper $helper) => $helper->beforeScenario()
        );
    }
}
