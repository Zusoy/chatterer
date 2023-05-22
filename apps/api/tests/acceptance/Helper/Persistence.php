<?php

declare(strict_types=1);

namespace Test\Acceptance\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Repository\Invitations;
use Domain\Repository\Stations;
use Domain\Repository\Users;
use Infra\Doctrine\Truncater;
use Test\Acceptance\Helper;

class Persistence extends Helper
{
    public function __construct(
        public readonly Users $users,
        public readonly Stations $stations,
        public readonly Invitations $invitations,
        public readonly EntityManagerInterface $manager,
        private readonly Truncater $truncater
    ) {
    }

    /**
     * {@inheritDoc}
     */
    final public function beforeScenario(): void
    {
    }

    public function clear(): void
    {
        $this->truncater->truncateAll();
    }
}
