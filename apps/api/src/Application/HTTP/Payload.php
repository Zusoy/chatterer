<?php

declare(strict_types=1);

namespace Application\HTTP;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class Payload
{
    public function __construct(private readonly Request $request)
    {
    }

    /**
     * @return string|int|float|bool|null
     */
    public function mandatory(string $name): mixed
    {
        if (!$this->request->request->has($name) && !$this->request->query->has($name)) {
            throw new BadRequestHttpException("Parameter '{$name}' is missing.");
        }

        return $this->optional($name);
    }

    /**
     * @param string|int|float|bool|null $defaultValue
     *
     * @return string|int|float|bool|null
     */
    public function optional(string $name, mixed $defaultValue = null): mixed
    {
        /** @var string|null */
        $default = $this->request->request->get($name, $defaultValue);

        return $this->request->query->get($name, $default);
    }

    /**
     * @return array<string|int|float|bool>
     */
    public function mandatories(string $name): array
    {
        if (!$this->request->request->has($name) && !$this->request->query->has($name)) {
            throw new BadRequestHttpException("Parameter '{$name}' is missing.");
        }

        return $this->optionals($name);
    }

    /**
     * @return array<string|int|float|bool>
     */
    public function optionals(string $name): array
    {
        /** @var array<string|int|float|bool> */
        $results = array_merge(
            $this->request->request->all($name),
            $this->request->query->all($name),
        );

        return $results;
    }

    public function file(string $name): UploadedFile
    {
        if (!$this->request->files->has($name)) {
            throw new BadRequestHttpException("File '{$name}' is missing.");
        }

        $file = $this->request->files->get($name);

        if (!$file instanceof UploadedFile) {
            throw new BadRequestHttpException("File '{$name}' is invalid.");
        }

        return $file;
    }
}
