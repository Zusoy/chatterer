<?php

declare(strict_types=1);

namespace Test\Acceptance\Helper;

use Test\Acceptance\Helper;
use JsonSchema\Validator as SchemaValidator;

class Validator extends Helper
{
    public function __construct(private readonly string $schemasBasePath)
    {
    }

    /**
     * {@inheritDoc}
     */
    final public function beforeScenario(): void
    {
    }

    /**
     * @return array<string,mixed>
     */
    public function validate(mixed $data, string $schema): array
    {
        $validator = new SchemaValidator();
        $validator->validate($data, (object) ['$ref' => "file://{$this->getSchemaFilePath($schema)}"]);

        return $validator->getErrors();
    }

    private function getSchemaFilePath(string $schema): string
    {
        return $this->schemasBasePath.'/'.$schema.'.json';
    }
}
