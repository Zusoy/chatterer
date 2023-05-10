<?php

namespace Infra\Symfony\Event\Listener;

use Assert\AssertionFailedException;
use Assert\LazyAssertionException;
use ReflectionClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

final class FormatExceptionResponseListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $error = $event->getThrowable();

        $event->setResponse(
            new JsonResponse(
                data: $this->formatExceptionData($error),
                status: $this->extractStatusCodeFromException($error),
                json: true
            )
        );
    }

    private function formatExceptionData(Throwable $error): string
    {
        $errorData = [
            'code' => $error->getCode(),
            'type' => $this->translateErrorClassname($error::class),
            'message' => $error->getMessage(),
            'extra' => [],
        ];

        $previous = $error->getPrevious();
        if ($error instanceof BadRequestHttpException) {
            $assertionErrors = [];

            switch (true) {
                case $previous instanceof LazyAssertionException:
                    /** @var LazyAssertionException $previous  */
                    $assertionErrors = $previous->getErrorExceptions();
                    $errorData['message'] = 'Validation failed on request body';
                    break;

                case $previous instanceof AssertionFailedException:
                    $assertionErrors = [$previous];
                    break;
            }

            foreach ($assertionErrors as $assertionError) {
                $errorData['extra'][$assertionError->getPropertyPath() ?: 'undefined'][] = [
                    'message' => $assertionError->getMessage(),
                    'context' => $assertionError->getValue(),
                ];
            }
        }

        if ($error instanceof AccessDeniedHttpException && $previous) {
            $errorData['extra']['previous'] = $previous->getMessage();
        }

        return json_encode(['error' => $errorData], JSON_THROW_ON_ERROR);
    }

    private function extractStatusCodeFromException(Throwable $error): int
    {
        if ($error instanceof HttpExceptionInterface) {
            return $error->getStatusCode();
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * @param class-string $classname
     */
    private function translateErrorClassname(string $classname): string
    {
        $refl = new ReflectionClass($classname);

        return str_replace(
            'Exception',
            '',
            $refl->getShortName()
        );
    }
}
