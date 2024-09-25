<?php

declare(strict_types=1);

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Identity\Identifier;
use Domain\Model\Forum\Forum;
use Domain\Model\Forum\Subject;

final class Subjects implements \Domain\Repository\Subjects
{
    /**
     * @var EntityRepository<Subject>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(Subject::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Subject $subject): void
    {
        $this->manager->persist($subject);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find(Identifier $identifier): ?Subject
    {
        return $this->repository->find($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(Forum $forum): iterable
    {
        /** @var iterable<Subject> */
        $results = $this->repository
            ->createQueryBuilder('sub')
            ->andWhere('sub.forum = :forum')
            ->setParameter('forum', $forum)
            ->orderBy('sub.createdAt', 'ASC')
            ->getQuery()
            ->getResult();

        return $results;
    }
}
