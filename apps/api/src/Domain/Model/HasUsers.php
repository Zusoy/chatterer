<?php

declare(strict_types=1);

namespace Domain\Model;

use Stringable;

interface HasUsers extends Stringable
{
    public function add(User $user): void;

    public function remove(User $user): void;

    public function has(User $user): bool;
}
