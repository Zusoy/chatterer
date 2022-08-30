<?php

namespace Application\Messaging\Transaction;

use Doctrine\ORM\EntityManagerInterface;

final class PersistenceTransaction implements Transaction
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function begin(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->flush();
        $this->entityManager->commit();
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }
}
