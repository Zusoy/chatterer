<?php

namespace Application\Auth\Token;

use Application\Auth\Extractor;
use Application\Auth\Tokenizer;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use InvalidArgumentException;

final class HS256Token implements Tokenizer, Extractor
{
    private const ALGORITHM = 'HS256';

    public function __construct(private string $key)
    {
    }

    public function createToken(string $username): string
    {
        return JWT::encode(
            ['chat:user' => $username],
            $this->key,
            self::ALGORITHM
        );
    }

    public function extract(string $token, string $claim): string
    {
        $decodedToken = (array) JWT::decode(
            $token,
            new Key($this->key, self::ALGORITHM),
        );

        if (!array_key_exists($claim, $decodedToken)) {
            throw new InvalidArgumentException(sprintf("Claim '%s' not found in JWT", $claim));
        }

        return (string) $decodedToken[$claim];
    }
}
