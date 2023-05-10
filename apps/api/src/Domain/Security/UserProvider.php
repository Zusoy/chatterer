<?php

declare(strict_types=1);

namespace Domain\Security;

use Domain\Model\User;

interface UserProvider
{
    public function getCurent(): ?User;

    public function setCurrent(User $user): void;
}
