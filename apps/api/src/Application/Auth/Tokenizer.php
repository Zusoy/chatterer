<?php

declare(strict_types=1);

namespace Application\Auth;

interface Tokenizer
{
    public function createToken(string $username): string;
}
