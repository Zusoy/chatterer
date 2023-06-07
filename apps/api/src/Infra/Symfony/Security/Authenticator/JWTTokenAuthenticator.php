<?php

declare(strict_types=1);

namespace Infra\Symfony\Security\Authenticator;

use Application\Auth\Extractor;
use DomainException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use UnexpectedValueException;

final class JWTTokenAuthenticator extends AbstractAuthenticator
{
    private const AUTH_SCHEME = 'Bearer ';

    public function __construct(private readonly Extractor $extractor)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request): ?bool
    {
        if (!$authorization = $request->headers->get('Authorization')) {
            return false;
        }

        return 0 === strpos($authorization, self::AUTH_SCHEME);
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(Request $request): Passport
    {
        if (!$authorization = $request->headers->get('Authorization')) {
            throw new AuthenticationCredentialsNotFoundException('Authorization token not found');
        }

        $token = $this->getAuthorizationToken($authorization);

        try {
            $username = $this->extractor->extract(
                (string) $token,
                'chat:user'
            );
        } catch (InvalidArgumentException $error) {
            throw new AuthenticationCredentialsNotFoundException('Invalid JWT provided.', previous: $error);
        } catch (UnexpectedValueException|DomainException $error) {
            throw new BadCredentialsException('Invalid JWT provided.', previous: $error);
        }

        return new SelfValidatingPassport(
            new UserBadge(userIdentifier: $username),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(
            data: [
                'error' => [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'extra' => null !== $exception->getPrevious()
                        ? ['token' => [$exception->getPrevious()->getMessage()]]
                        : [],
                ],
            ],
            status: Response::HTTP_FORBIDDEN,
        );
    }

    private function getAuthorizationToken(string $authorization): string
    {
        return substr($authorization, offset: strlen(self::AUTH_SCHEME));
    }
}
