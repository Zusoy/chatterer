<?php

declare(strict_types=1);

namespace Domain\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Identity\Identifiable;
use Domain\Identity\Identifier;
use Domain\Model\User;
use Domain\Time\HasTimestamp;
use Domain\Time\HasTimestampTrait;

class Station implements Identifiable, HasTimestamp, HasUsers
{
    use HasTimestampTrait;

    private Identifier $id;
    private string $name;
    private ?string $description;
    /** @var Collection<int,Channel> */
    private Collection $channels;
    /** @var Collection<int,User> */
    private Collection $users;

    public function __construct(string $name, ?string $description)
    {
        $this->id = Identifier::generate();
        $this->name = $name;
        $this->description = $description;
        $this->channels = new ArrayCollection();
        $this->users = new ArrayCollection();

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getIdentifier(): Identifier
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return Channel[]
     */
    public function getChannels(): array
    {
        return $this->channels->toArray();
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
