<?php

declare(strict_types=1);

namespace Domain\Time;

use DateTimeImmutable;

/**
 * @see HasTimestamp
 */
trait HasTimestampTrait
{
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
