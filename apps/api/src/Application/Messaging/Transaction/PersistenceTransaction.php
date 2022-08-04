<?php

namespace Application\Messaging\Transaction;

use Doctrine\ORM\EntityManagerInterface;

final class PersistenceTransaction implements Transaction
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function begin()
    {
        $this->entityManager->beginTransaction();
    }

    public function commit()
    {
        $this->entityManager->flush();
        $this->entityManager->commit();
    }

    public function rollback()
    {
        $this->entityManager->close();
        $this->entityManager->rollback();
    }
}
