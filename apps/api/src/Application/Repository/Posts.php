<?php

declare(strict_types=1);

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Identity\Identifier;
use Domain\Model\Forum\Post;
use Domain\Model\Forum\Subject;

final class Posts implements \Domain\Repository\Posts
{
    /**
     * @var EntityRepository<Post>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(Post::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Post $post): void
    {
        $this->manager->persist($post);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find(Identifier $identifier): ?Post
    {
        return $this->repository->find($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(Subject $subject): iterable
    {
        /** @var iterable<Post> */
        $results = $this->repository
            ->createQueryBuilder('post')
            ->andWhere('post.subject = :subject')
            ->setParameter('subject', $subject)
            ->orderBy('post.createdAt', 'ASC')
            ->getQuery()
            ->getResult();

        return $results;
    }
}
