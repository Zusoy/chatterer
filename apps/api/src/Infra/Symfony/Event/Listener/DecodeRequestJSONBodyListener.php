<?php

declare(strict_types=1);

namespace Infra\Symfony\Event\Listener;

use JsonException;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class DecodeRequestJSONBodyListener
{
    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ('json' !== $request->getContentType() || !$request->getContent()) {
            return;
        }

        try {
            $body = json_decode(
                json: (string) $request->getContent(),
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );

            $request->request->replace($body);
        } catch (JsonException $error) {
            throw new BadRequestHttpException('Invalid JSON provided', $error);
        }
    }
}
