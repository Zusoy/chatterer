<?php

namespace Application\HTTP\Controller;

use Domain\Message\Config as Message;
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
        $config = $this->bus->execute(new Message\Get());

        return $this->createJsonResponse(
            data: $config,
            status: Response::HTTP_OK,
            normalize: false
        );
    }
}
