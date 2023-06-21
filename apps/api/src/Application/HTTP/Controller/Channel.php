<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Command\Channel as Command;
use Domain\Identity\Identifier;
use Infra\Symfony\Controller\BaseController;
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
        $channels = $this->bus->execute(new Command\All($stationId));

        return $this->createJsonResponse(
            data: $channels,
            status: Response::HTTP_OK,
            discoveryTopic: "channel/list/{$stationId}"
        );
    }

    #[Route('station/{stationId}/channels', name: 'create', requirements: ['stationId' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function create(string $stationId, Payload $payload): Response
    {
        $channel = $this->bus->execute(new Command\Create(
            $stationId,
            name: (string) $payload->mandatory('name'),
            description: (string) $payload->optional('description')
        ));

        return $this->createJsonResponse(
            data: $channel,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('channel/{id}', name: 'update', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_PUT])]
    public function update(string $id, Payload $payload): Response
    {
        $channel = $this->bus->execute(new Command\Update(
            $id,
            name: (string) $payload->mandatory('name'),
            description: (string) $payload->optional('description')
        ));

        return $this->createJsonResponse(
            data: $channel,
            status: Response::HTTP_OK
        );
    }

    #[Route('channel/{id}', name: 'delete', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_DELETE])]
    public function delete(string $id): Response
    {
        $this->bus->execute(new Command\Delete($id));

        return $this->createJsonResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
