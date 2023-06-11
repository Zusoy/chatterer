<?php

declare(strict_types=1);

namespace Infra\Symfony\Event\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class HandleCORSPermissionListener
{
    private const COMMON_PORTS = [
        'http' => '80',
        'https' => '443',
    ];

    private const ALLOW_METHODS = [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'PATCH',
        'OPTIONS',
    ];

    private const ALLOW_HEADERS = [
        'Content-Type',
        'Accept',
    ];

    private const EXPOSE_HEADERS = [
        'Link',
        'X-Total-Count',
    ];

    /**
     * @param string[] $allowedPorts
     */
    public function __construct(
        private readonly array $allowedPorts,
        private readonly string $defaultOriginHost,
        private readonly string $defaultOriginPort
    ) {
    }

    public function __invoke(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $origin = $this->getRequestOrigin($request);

        if (!in_array($this->getOriginPort($origin), $this->allowedPorts)) {
            $origin = $this->getDefaultOrigin();
        }

        $linearize = static fn (array $values): string => implode(', ', $values);

        $event->getResponse()->headers->add(
            [
                'Access-Control-Allow-Origin' => $origin,
                'Access-Control-Allow-Methods' => $linearize(self::ALLOW_METHODS),
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => $linearize(array_filter([
                    ...self::ALLOW_HEADERS,
                    ...explode(',', (string) $request->headers->get('Access-Control-Request-Headers')),
                ])),
                'Access-Control-Expose-Headers' => $linearize(self::EXPOSE_HEADERS),
            ]
        );
    }

    private function getRequestOrigin(Request $request): string
    {
        $origin = $request->headers->get('Origin', $request->headers->get('Referer', $this->getDefaultOrigin()));

        return trim((string) $origin, '/');
    }

    private function getDefaultOrigin(): string
    {
        $origin = trim($this->defaultOriginHost, '/');

        if (!in_array($this->defaultOriginPort, self::COMMON_PORTS)) {
            $origin = "$origin:{$this->defaultOriginPort}";
        }

        return $origin;
    }

    private function getOriginPort(string $origin): string
    {
        $parts = parse_url($origin);

        if (false !== $parts) {
            if (!empty($parts['port'])) {
                return (string) $parts['port'];
            }

            if ('https' === ($parts['scheme'] ?? '')) {
                return self::COMMON_PORTS['https'];
            }
        }

        return self::COMMON_PORTS['http'];
    }
}
