<?php

declare(strict_types=1);

namespace Test\Acceptance;

use Behat\Behat\Context\Context as BehatContext;
use Faker\Generator;
use Infra\Assert\Assert;

abstract class Context implements BehatContext
{
    /**
     * @var Helper[]
     */
    private array $helpers = [];

    /**
     * @param Generator $faker (with DomainProvider)
     */
    public function __construct(
        protected readonly Helper\Http $http,
        protected readonly Helper\Database $database,
        protected readonly Helper\Schema $schema,
        protected readonly Generator $faker,
    ) {
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

    protected function validateJsonSchema(mixed $data, string $schema): void
    {
        $errors = $this->schema->validate($data, $schema);

        Assert::that($errors)->count(
            0,
            implode(
                "\n",
                array_map(
                    fn ($error) => sprintf('[%s] %s', $error['property'], $error['message']),
                    $errors,
                )
            )
        );
    }
}
