<?php

namespace Infra\Symfony\Security\Authenticator;

use Application\Auth\Tokenizer;
use Application\Normalization\Normalizer;
use Application\Serialization\Serializer;
use Domain\Model\User;
use Domain\Repository\Users;
use Infra\Symfony\Security\AuthCookie;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

final class UserPasswordAuthenticator extends AbstractAuthenticator
{
    private const LOGIN_ROUTE = '/auth';

    /**
     * @param Normalizer<User> $normalizer
     */
    public function __construct(
        private Users $users,
        private Normalizer $normalizer,
        private Serializer $serializer,
        private Tokenizer $tokenizer
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request): ?bool
    {
        if (self::LOGIN_ROUTE !== $request->getPathInfo() || !$request->isMethod(Request::METHOD_POST)) {
            return false;
        }

        $request = $request->request;

        return $request->has('username') && $request->has('password');
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(Request $request): Passport
    {
        $username = (string) $request->request->get('username');
        $password = (string) $request->request->get('password');

        if (!$this->users->findByEmail($username)) {
            throw new UserNotFoundException("$username does not exist");
        }

        return new Passport(
            new UserBadge(userIdentifier: $username),
            new PasswordCredentials(password: $password)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            throw new InvalidArgumentException(sprintf('User type %s required', User::class));
        }

        if (!$user->getUserIdentifier()) {
            throw new UnsupportedUserException('User does not have a username.');
        }

        $normalizedUser = $this->normalizer->normalize($user);

        $response = new JsonResponse(
            data: $this->serializer->serialize($normalizedUser, Serializer::JSON_FORMAT),
            status: Response::HTTP_OK,
            json: true
        );

        $response->headers->setCookie(AuthCookie::fromToken(
            $this->tokenizer->createToken($user->getUserIdentifier())
        ));

        return $response;
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
                ],
            ],
            status: Response::HTTP_FORBIDDEN
        );
    }
}
