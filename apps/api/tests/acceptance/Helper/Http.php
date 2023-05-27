<?php

declare(strict_types=1);

namespace Test\Acceptance\Helper;

use Application\Auth\Tokenizer;
use Infra\Symfony\Security\AuthCookie;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Test\Acceptance\Helper;

class Http extends Helper
{
    private ?Response $lastResponse = null;
    private ?string $token = null;

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly Tokenizer $tokenizer
    ) {
    }

    /**
     * {@inheritDoc}
     */
    final public function beforeScenario(): void
    {
        $this->lastResponse = null;
        $this->token = null;
    }

    public function auth(string $username): void
    {
        $this->token = $this->tokenizer->createToken($username);
    }

    /**
     * @throws RuntimeException If no response received during current scenario
     */
    public function getLastResponse(): Response
    {
        if (null === $this->lastResponse) {
            throw new RuntimeException('No response received during the current scenario');
        }

        return $this->lastResponse;
    }

    /**
     * @return array<mixed>
     *
     * @throws RuntimeException If no valid JSON response received during current scenario
     */
    public function getLastJson(): array
    {
        $response = $this->getLastResponse();
        $content = $response->getContent();

        if (false === $content) {
            throw new RuntimeException('No valid JSON response received during the current scenario');
        }

        return json_decode(
            json: $content,
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /**
     * @throws RuntimeException If no valid JSON response received during current scenario
     */
    public function getLastJsonObjects(): mixed
    {
        $response = $this->getLastResponse();
        $content = $response->getContent();

        if (false === $content) {
            throw new RuntimeException('No valid JSON response received during the current scenario');
        }

        return json_decode(
            json: $content,
            associative: false,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param array<string,string> $headers
     */
    public function get(string $uri, array $headers = []): Response
    {
        return $this->request(Request::METHOD_GET, $uri, headers: $headers);
    }

    /**
     * @param mixed                 $content
     * @param array<string,string>  $headers
     */
    public function post(string $uri, $content = null, array $headers = []): Response
    {
        return $this->request(Request::METHOD_POST, $uri, $content, $headers);
    }

    /**
     * @param mixed                 $content
     * @param array<string,string>  $headers
     */
    public function put(string $uri, $content = null, array $headers = []): Response
    {
        return $this->request(Request::METHOD_PUT, $uri, $content, $headers);
    }

    /**
     * @param array<string,string> $headers
     */
    public function delete(string $uri, array $headers = []): Response
    {
        return $this->request(Request::METHOD_DELETE, $uri, null, $headers);
    }

    /**
     * @param array<string,string> $headers
     */
    final protected function request(
        string $method,
        string $uri,
        $content = null,
        array $headers = []
    ): Response {
        $request = Request::METHOD_GET === $method
            ? Request::create($uri, $method)
            : Request::create($uri, $method, content: json_encode($content, JSON_THROW_ON_ERROR));

        if ($request->getMethod() !== Request::METHOD_GET) {
            $request->headers->set('Content-Type', 'application/json');
        }

        foreach ($headers as $key => $value) {
            $request->headers->set($key, $value);
        }

        if ($this->token !== null) {
            $request->cookies->set(AuthCookie::NAME, $this->token);
        }

        return $this->lastResponse = $this->kernel->handle($request);
    }
}
