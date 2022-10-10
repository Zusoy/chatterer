<?php

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Identity\Identifier;
use Domain\Message\Channel as Message;
use Infra\Framework\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'channel_')]
final class Channel extends BaseController
{
    #[Route('station/{stationId}/channels', name: 'list', requirements: ['stationId' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function list(string $stationId): Response
    {
        /** @var iterable<\Domain\Model\Channel> */
        $channels = $this->bus->execute(new Message\All($stationId));

        return $this->createJsonResponse(
            data: $channels,
            status: Response::HTTP_OK
        );
    }

    #[Route('station/{stationId}/channels', name: 'create', requirements: ['stationId' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function create(string $stationId, Payload $payload): Response
    {
        $channel = $this->bus->execute(new Message\Create(
            $stationId,
            $payload->mandatory('name'),
            $payload->optional('description')
        ));

        return $this->createJsonResponse(
            data: $channel,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('channel/{id}', name: 'update', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_PUT])]
    public function update(string $id, Payload $payload): Response
    {
        $channel = $this->bus->execute(new Message\Update(
            $id,
            $payload->mandatory('name'),
            $payload->optional('description')
        ));

        return $this->createJsonResponse(
            data: $channel,
            status: Response::HTTP_OK
        );
    }
}
