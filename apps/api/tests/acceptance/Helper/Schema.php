<?php

declare(strict_types=1);

namespace Test\Acceptance\Helper;

use Test\Acceptance\Helper;
use JsonSchema\Validator;

final class Schema extends Helper
{
    public function __construct(private readonly string $basePath)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function beforeScenario(): void
    {
    }

    public function validate(mixed $data, string $schema): array
    {
        $validator = new Validator();
        $validator->validate($data, (object) ['$ref' => "file://{$this->getSchemaFilePath($schema)}"]);

        return $validator->getErrors();
    }

    private function getSchemaFilePath(string $schema): string
    {
        return $this->basePath.'/'.$schema.'.json';
    }
}
