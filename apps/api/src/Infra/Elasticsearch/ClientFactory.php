<?php

declare(strict_types=1);

namespace Infra\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;

final class ClientFactory
{
    private ?string $username = null;
    private ?string $password = null;

    /**
     * @param array<string> $hosts
     */
    public function __construct(
        private readonly array $hosts,
        private readonly string $credentials
    ) {
        if (strlen($credentials) > 0 && -1 !== strpos($credentials, ':')) {
            [$this->username, $this->password] = explode(':', $credentials);
        }
    }

    public function create(): Client
    {
        if (null === $this->username || null === $this->password) {
            throw new Exception('Invalid credentials for elasticsearch client');
        }

        $clientBuilder = ClientBuilder::create();
        $clientBuilder
            ->setHosts($this->hosts)
            ->setBasicAuthentication($this->username, $this->password)
        ;

        return $clientBuilder->build();
    }
}
