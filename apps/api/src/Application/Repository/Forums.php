<?php

declare(strict_types=1);

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Identity\Identifier;
use Domain\Model\Forum\Forum;
use Domain\Model\Station;

final class Forums implements \Domain\Repository\Forums
{
    /**
     * @var EntityRepository<Forum>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(Forum::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Forum $forum): void
    {
        $this->manager->persist($forum);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find(Identifier $identifier): ?Forum
    {
        return $this->repository->find($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(Station $station): iterable
    {
        /** @var iterable<Forum> */
        $results = $this->repository
            ->createQueryBuilder('frm')
            ->andWhere('frm.station = :station')
            ->setParameter('station', $station)
            ->orderBy('frm.createdAt', 'ASC')
            ->getQuery()
            ->getResult();

        return $results;
    }
}
