<?php

namespace Infra\Framework\Event\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class PreflightRequestListerer
{
    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($event->isMainRequest() && $request->isMethod('OPTIONS')) {
            $event->setResponse(new JsonResponse([], status: JsonResponse::HTTP_OK));
        }
    }
}
