<?php

namespace Infra\Framework\Event\Listener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class HandleCORSPermissionListener
{
    public function __construct(private string $allowedPorts)
    {
    }

    public function __invoke(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        $event->getResponse()->headers->add(
            [
                'Access-Control-Allow-Origin' => $this->allowedPorts,
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => $request->headers->get('Access-Control-Request-Headers'),
                'Access-Control-Expose-Headers' => ['Link', 'X-Total-Count'],
            ]
        );
    }
}
