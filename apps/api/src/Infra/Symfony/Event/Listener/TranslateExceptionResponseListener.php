<?php

declare(strict_types=1);

namespace Infra\Symfony\Event\Listener;

use Domain\Exception\ObjectNotFoundException;
use Domain\Exception\OperationDeniedException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class TranslateExceptionResponseListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $error = $event->getThrowable();

        switch (true) {
            case $error instanceof ObjectNotFoundException:
                $event->setThrowable(new NotFoundHttpException(
                    message: $error->getMessage(),
                    previous: $error
                ));
                break;

            case $error instanceof OperationDeniedException:
                $event->setThrowable(new AccessDeniedHttpException(
                    message: $error->getMessage(),
                    previous: $error
                ));
                break;

            case $error instanceof InvalidArgumentException:
                $event->setThrowable(new BadRequestHttpException(
                    message: $error->getMessage(),
                    previous: $error
                ));
                break;
        }
    }
}
