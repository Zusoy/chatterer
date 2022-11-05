<?php

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Identity\Identifier;
use Domain\Model\User;

final class Users implements \Domain\Repository\Users
{
    /**
     * @var EntityRepository<User>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(User::class);
    }

    public function find(Identifier $identifier): ?User
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

    public function add(User $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}
