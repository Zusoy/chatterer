<?php

namespace Application\Auth;

interface Tokenizer
{
    public function createToken(string $username): string;
}
