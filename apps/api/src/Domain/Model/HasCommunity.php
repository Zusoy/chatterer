<?php

namespace Domain\Model;

use Stringable;

interface HasCommunity extends Stringable
{
    public function add(User $user): void;

    public function remove(User $user): void;

    public function has(User $user): bool;
}
