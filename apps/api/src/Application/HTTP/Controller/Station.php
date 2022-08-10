<?php

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Message\Station as Message;
use Infra\Framework\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'station_')]
final class Station extends BaseController
{
    #[Route('/stations', name: 'list', methods: [Request::METHOD_GET])]
    public function list(): Response
    {
        $stations = $this->bus->execute(new Message\All());

        return $this->createJsonResponse(
            data: $stations
        );
    }

    #[Route('/stations', name: 'create', methods: [Request::METHOD_POST])]
    public function create(Payload $payload): Response
    {
        $station = $this->bus->execute(new Message\Create(
            $payload->mandatory('name'),
            $payload->optional('description')
        ));

        return new JsonResponse(
            data: $station,
            status: Response::HTTP_CREATED
        );
    }
}