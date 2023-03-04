<?php

declare(strict_types=1);

namespace Test\Acceptance\Helper;

use Application\Auth\Tokenizer;
use Infra\Framework\Security\AuthCookie;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Test\Acceptance\Helper;

final class Http extends Helper
{
    private ?Response $response = null;
    private ?string $token = null;

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly Tokenizer $tokenizer
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function beforeScenario(): void
    {
        $this->response = null;
        $this->token = null;
    }

    public function auth(string $username): void
    {
        $this->token = $this->tokenizer->createToken($username);
    }

    /**
     * @throws RuntimeException
     */
    public function getLastResponse(): Response
    {
        if (null === $this->response) {
            throw new RuntimeException('No response received.');
        }

        return $this->response;
    }

    /**
     * @throws RuntimeException
     *
     * @return array<mixed>
     */
    public function getLastJson(): array
    {
        $response = $this->getLastResponse();
        $content = $response->getContent();

        if (false === $content) {
            throw new RuntimeException('No valid JSON response received.');
        }

        return json_decode(
            json: $content,
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /**
     * @throws RuntimeException
     */
    public function getLastJsonObjects(): mixed
    {
        $response = $this->getLastResponse();
        $content = $response->getContent();

        if (false === $content) {
            throw new RuntimeException('No valid JSON response received.');
        }

        return json_decode(
            json: $content,
            associative: false,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param array<string, string> $headers
     */
    public function get(string $uri, array $headers = []): Response
    {
        return $this->request(
            'GET',
            $uri,
            headers: $headers
        );
    }

    /**
     * @param mixed                 $content
     * @param array<string, string> $headers
     */
    public function post(
        string $uri,
        $content = null,
        array $headers = []
    ): Response {
        return $this->request('POST', $uri, $content, $headers);
    }

    private function request(
        string $method,
        string $uri,
        $content = null,
        array $headers = []
    ): Response {
        $request = 'GET' === $method
            ? Request::create($uri, $method)
            : Request::create($uri, $method, content: json_encode($content, JSON_THROW_ON_ERROR));

        if ($request->getMethod() !== 'GET') {
            $request->headers->set('Content-Type', 'application/json');
        }

        foreach ($headers as $key => $value) {
            $request->headers->set($key, $value);
        }

        if ($this->token !== null) {
            $request->cookies->set(AuthCookie::NAME, $this->token);
        }

        return $this->response = $this->kernel->handle($request);
    }
}
