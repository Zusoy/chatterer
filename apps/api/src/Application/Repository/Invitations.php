<?php

declare(strict_types=1);

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Identity\Identifier;
use Domain\Model\Invitation;
use Domain\Model\Station;

final class Invitations implements \Domain\Repository\Invitations
{
    /**
     * @var EntityRepository<Invitation>
     */
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $manager)
    {
        $this->repository = $manager->getRepository(Invitation::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Invitation $invitation): void
    {
        $this->manager->persist($invitation);
        $this->manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find(Identifier $identifier): ?Invitation
    {
        return $this->repository->find($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function findByStation(Station $station): ?Invitation
    {
        return $this->repository->findOneBy(['station' => $station]);
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Invitation $invitation): void
    {
        $this->manager->remove($invitation);
        $this->manager->flush();
    }
}
