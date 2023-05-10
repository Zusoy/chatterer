<?php

declare(strict_types=1);

namespace Application\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
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

    public function add(Invitation $invitation): void
    {
        $this->manager->persist($invitation);
        $this->manager->flush();
    }

    public function findByStation(Station $station): ?Invitation
    {
        return $this->repository->findOneBy(['station' => $station]);
    }

    public function findByToken(string $token, Station $station): ?Invitation
    {
        return $this->repository->findOneBy([
            'token.value' => $token,
            'station' => $station
        ]);
    }

    public function remove(Invitation $invitation): void
    {
        $this->manager->remove($invitation);
        $this->manager->flush();
    }
}
