<?php

declare(strict_types=1);

namespace Application\Auth;

interface Extractor
{
    public function extract(string $token, string $claim): string;
}
