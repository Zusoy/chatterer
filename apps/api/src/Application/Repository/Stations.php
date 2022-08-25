<?php

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Model\Identity\Identifier;
use Domain\Model\Station;

final class Stations implements \Domain\Repository\Stations
{
    /**
     * @var EntityRepository<Station>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(Station::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Station $station): void
    {
        $this->manager->persist($station);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find(Identifier $identifier): ?Station
    {
        return $this->repository->find($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Station $station): void
    {
        $this->manager->remove($station);
        $this->manager->flush();
    }
}
