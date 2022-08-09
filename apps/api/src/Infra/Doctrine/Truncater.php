<?php

namespace Infra\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\TableNotFoundException;

final class Truncater
{
    private const EXCLUDED_TABLENAMES = ['doctrine_migration_versions'];

    /**
     * @var string[]
     */
    private ?array $_tables = null;

    public function __construct(private Connection $connection)
    {
    }

    public function truncateAll(): void
    {
        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->getTables() as $table) {
            try {
                $this->connection->executeStatement("TRUNCATE {$table}");
            } catch (TableNotFoundException $error) {
            }
        }

        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @return string[]
     */
    public function getTables(): array
    {
        if (null === $this->_tables) {
            $schemaManager = $this->connection->createSchemaManager();

            $this->_tables = array_filter(
                $schemaManager->listTableNames(),
                fn (string $table) => !in_array($table, self::EXCLUDED_TABLENAMES),
            );
        }

        return $this->_tables;
    }
}
