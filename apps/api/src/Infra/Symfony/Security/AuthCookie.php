<?php

namespace Infra\Symfony\Security;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Cookie;

final class AuthCookie extends Cookie
{
    public const NAME = '_ch_auth_token';

    public static function fromToken(?string $token): Cookie
    {
        return self::create(
            name: self::NAME,
            value: $token,
            expire: new DateTimeImmutable('+1 week'),
            secure: true,
            httpOnly: true,
            sameSite: self::SAMESITE_NONE,
        );
    }

    public static function invalidate(): Cookie
    {
        return self::fromToken(null)->withExpires(-1);
    }
}
