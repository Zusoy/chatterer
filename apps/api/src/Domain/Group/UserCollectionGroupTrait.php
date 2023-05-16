<?php

declare(strict_types=1);

namespace Domain\Group;

use Doctrine\Common\Collections\Collection;
use Domain\Model\User;

/**
 * @see UserGroup
 */
trait UserCollectionGroupTrait
{
    /** @var Collection<int,User> */
    private Collection $users;

    /**
     * {@inheritDoc}
     */
    final public function hasUser(User $user): bool
    {
        return $this->users->contains($user);
    }

    /**
     * {@inheritDoc}
     */
    final public function addUser(User $user): void
    {
        if ($this->users->contains($user)) {
            return;
        }

        $this->users->add($user);
    }

    /**
     * {@inheritDoc}
     */
    final public function removeUser(User $user): void
    {
        if (!$this->users->contains($user)) {
            return;
        }

        $this->users->removeElement($user);
    }

    /**
     * {@inheritDoc}
     */
    final public function getUsers(): iterable
    {
        return $this->users->toArray();
    }
}
