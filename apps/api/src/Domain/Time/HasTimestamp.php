<?php

namespace Domain\Time;

use DateTimeImmutable;

interface HasTimestamp
{
    public function touch(): void;

    public function getCreatedAt(): DateTimeImmutable;

    public function getUpdatedAt(): DateTimeImmutable;
}
