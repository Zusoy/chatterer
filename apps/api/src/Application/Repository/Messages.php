<?php

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Identity\Identifier;
use Domain\Model\Message;

final class Messages implements \Domain\Repository\Messages
{
    /**
     * @var EntityRepository<Message>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(Message::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Message $message): void
    {
        $this->manager->persist($message);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find(Identifier $identifier): ?Message
    {
        return $this->repository->find($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Message $message): void
    {
        $this->manager->remove($message);
        $this->manager->flush();
    }
}
