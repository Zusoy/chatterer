<?php

namespace Test\Acceptance\Helper;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Repository\Users;
use Infra\Doctrine\Truncater;
use Test\Acceptance\Helper;

final class Database extends Helper
{
    public function __construct(
        public readonly Users $users,
        public readonly EntityManagerInterface $em,
        private readonly Connection $connection,
        private readonly Truncater $truncater,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function beforeScenario(): void
    {
    }

    public function truncate(): void
    {
        $this->truncater->truncateAll();
    }

    /**
     * @return array<array<string,mixed>>
     */
    public function query(string $sql): array
    {
        $result = $this
            ->connection
            ->executeQuery($sql);

        return $result->fetchAllAssociative();
    }
}
