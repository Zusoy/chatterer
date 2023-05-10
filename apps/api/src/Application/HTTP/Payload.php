<?php

declare(strict_types=1);

namespace Application\HTTP;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class Payload
{
    public function __construct(private Request $request)
    {
    }

    public function mandatory(string $name): mixed
    {
        if (!$this->request->request->has($name) && !$this->request->query->has($name)) {
            throw new BadRequestHttpException("Parameter '{$name}' is missing.");
        }

        return $this->optional($name);
    }

    public function optional(string $name, mixed $defaultValue = null): mixed
    {
        return $this->request->query->get($name, $this->request->request->get($name, $defaultValue));
    }

    /**
     * @return mixed[]
     */
    public function mandatories(string $name): array
    {
        if (!$this->request->request->has($name) && !$this->request->query->has($name)) {
            throw new BadRequestHttpException("Parameter '{$name}' is missing.");
        }

        return $this->optionals($name);
    }

    /**
     * @return mixed[]
     */
    public function optionals(string $name): array
    {
        return array_merge(
            $this->request->request->all($name),
            $this->request->query->all($name),
        );
    }

    public function file(string $name): UploadedFile
    {
        if (!$this->request->files->has($name)) {
            throw new BadRequestHttpException("File '{$name}' is missing.");
        }

        return $this->request->files->get($name);
    }
}
