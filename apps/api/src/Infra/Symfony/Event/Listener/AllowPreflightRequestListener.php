<?php

declare(strict_types=1);

namespace Infra\Symfony\Event\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class AllowPreflightRequestListener
{
    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($event->isMainRequest() && $request->isMethod(Request::METHOD_OPTIONS)) {
            $event->setResponse(new JsonResponse(data: [], status: Response::HTTP_OK));
        }
    }
}
