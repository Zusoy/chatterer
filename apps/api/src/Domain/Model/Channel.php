<?php

namespace Domain\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\User;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Channel implements Identifiable, HasTimestamp, HasUsers
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $name;
    private ?string $description;
    private Station $station;
    /** @var Collection<int,User> */
    private Collection $users;

    public function __construct(Station $station, string $name, ?string $description)
    {
        $this->id = Identifier::generate();
        $this->station = $station;
        $this->name = $name;
        $this->description = $description;
        $this->users = new ArrayCollection();

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function getStationIdentifier(): Identifier
    {
        return $this->station->getIdentifier();
    }

    public function getStationName(): string
    {
        return $this->station->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * {@inheritDoc}
     */
    public function add(User $user): void
    {
        if ($this->users->contains($user)) {
            return;
        }

        $this->users->add($user);
    }

    /**
     * {@inheritDoc}
     */
    public function remove(User $user): void
    {
        if (!$this->users->contains($user)) {
            return;
        }

        $this->users->removeElement($user);
    }

    /**
     * {@inheritDoc}
     */
    public function has(User $user): bool
    {
        return $this->users->contains($user);
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
