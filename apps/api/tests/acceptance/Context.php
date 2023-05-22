<?php

declare(strict_types=1);

namespace Test\Acceptance;

use Behat\Behat\Context\Context as BehatContext;
use Faker\Generator;
use Infra\Assert\Assert;
use Test\Acceptance\Helper as Helper;

abstract class Context implements BehatContext
{
    /**
     * @var array<Helper>
     */
    private array $helpers = [];

    public function __construct(
        protected readonly Helper\Http $http,
        protected readonly Helper\Persistence $persistence,
        protected readonly Helper\Validator $validator,
        protected readonly Generator $faker
    ) {
        $this->helpers = array_filter(
            \func_get_args(),
            static fn (mixed $arg): bool => $arg instanceof Helper,
        );
    }

    /**
     * @BeforeScenario
     */
    final public function beforeScenarioForAllHelpers(): void
    {
        array_walk(
            $this->helpers,
            static fn (Helper $helper) => $helper->beforeScenario()
        );
    }

    protected function validateJsonSchema(mixed $data, string $schema): void
    {
        $errors = $this->validator->validate($data, $schema);

        Assert::that($errors)->count(
            0,
            implode(
                "\n",
                array_map(
                    static fn ($error) => sprintf('[%s] %s', $error['property'], $error['message']),
                    $errors,
                )
            )
        );
    }
}
