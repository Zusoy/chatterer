<?php

declare(strict_types=1);

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Identity\Identifier;
use Domain\Model\Channel;

final class Channels implements \Domain\Repository\Channels
{
    /**
     * @var EntityRepository<Channel>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(Channel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Channel $channel): void
    {
        $this->manager->persist($channel);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find(Identifier $identifier): ?Channel
    {
        return $this->repository->find($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function findByName(Identifier $stationId, string $name): ?Channel
    {
        return $this->repository->findOneBy(['name' => $name, 'station' => $stationId]);
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Channel $channel): void
    {
        $this->manager->remove($channel);
        $this->manager->flush();
    }
}
