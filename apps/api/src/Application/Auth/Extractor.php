<?php

namespace Application\Auth;

interface Extractor
{
    public function extract(string $token, string $claim): string;
}
