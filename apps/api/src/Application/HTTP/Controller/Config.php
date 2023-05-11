<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Domain\Command\Config as Command;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'config_')]
final class Config extends BaseController
{
    #[Route('/config', name: 'get', methods: [Request::METHOD_GET])]
    public function get(): Response
    {
        $config = $this->bus->execute(new Command\Get());

        return $this->createJsonResponse(
            data: $config,
            status: Response::HTTP_OK,
            normalize: false
        );
    }
}
