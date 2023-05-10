<?php

declare(strict_types=1);

namespace Domain\Identity;

interface Identifiable
{
    public function getIdentifier(): Identifier;
}
