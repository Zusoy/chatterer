<?php

namespace Infra\Symfony\Security\Authenticator;

use Application\Auth\Extractor;
use DomainException;
use Infra\Symfony\Security\AuthCookie;
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
    public function __construct(private Extractor $extractor)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request): ?bool
    {
        return $request->cookies->has(AuthCookie::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(Request $request): Passport
    {
        if (!$token = $request->cookies->get(AuthCookie::NAME)) {
            throw new AuthenticationCredentialsNotFoundException('Auth cookie not found');
        }

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
}
