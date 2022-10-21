<?php

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Model\Message;

final class Messages implements \Domain\Repository\Messages
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function add(Message $message): void
    {
        $this->manager->persist($message);
        $this->manager->flush();
    }
}
