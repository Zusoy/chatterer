<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Application\HTTP\Payload\Channel as Payload;
use Domain\Command\Channel as Command;
use Domain\Identity\Identifier;
use Domain\Model\User;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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
    public function create(string $stationId, #[MapRequestPayload()] Payload\Create $payload): Response
    {
        $channel = $this->bus->execute(new Command\Create(
            $stationId,
            name: $payload->name,
            description: $payload->description
        ));

        return $this->createJsonResponse(
            data: $channel,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('channel/{id}', name: 'update', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_PUT])]
    public function update(string $id, #[MapRequestPayload()] Payload\Update $payload): Response
    {
        $channel = $this->bus->execute(new Command\Update(
            $id,
            name: $payload->name,
            description: $payload->description
        ));

        return $this->createJsonResponse(
            data: $channel,
            status: Response::HTTP_OK
        );
    }

    #[Route('channel/{id}/join', name: 'join', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function join(string $id): Response
    {
        $channel = $this->bus->execute(new Command\AddUser(
            channelId: $id,
            userId: (string) $this->getCurrentUser()->getIdentifier()
        ));

        return $this->createJsonResponse(
            data: $channel,
            status: Response::HTTP_OK
        );
    }

    #[Route('channel/{id}/users', name: 'list_users', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function users(string $id): Response
    {
        /** @var User[] */
        $users = $this->bus->execute(new Command\ListUsers($id));

        return $this->createJsonResponse(
            data: $users,
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
