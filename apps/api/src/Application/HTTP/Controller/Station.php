<?php

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Identity\Identifier;
use Domain\Message\Station as Message;
use Domain\Model\Invitation;
use Infra\Framework\Controller\BaseController;
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
            data: $stations,
            discoveryTopic: 'station/list'
        );
    }

    #[Route('/station/{id}', name: 'get', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function get(string $id): Response
    {
        $station = $this->bus->execute(new Message\Get($id));

        return $this->createJsonResponse(
            data: $station,
            discoveryTopic: "station/{$id}"
        );
    }

    #[Route('/stations', name: 'create', methods: [Request::METHOD_POST])]
    public function create(Payload $payload): Response
    {
        $station = $this->bus->execute(new Message\Create(
            $payload->mandatory('name'),
            $payload->optional('description')
        ));

        return $this->createJsonResponse(
            data: $station,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('/station/{id}/invite', name: 'invite', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function invite(string $id): Response
    {
        /** @var Invitation */
        $invitation = $this->bus->execute(new Message\Invite($id));

        return $this->createJsonResponse(
            data: $invitation,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('/station/{id}/join', name: 'join', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function join(string $id, Payload $payload): Response
    {
        $station = $this->bus->execute(new Message\Join(
            stationId: $id,
            userId: $this->getCurrentUser()->getIdentifier(),
            token: $payload->mandatory('token')
        ));

        return $this->createJsonResponse(
            data: $station,
            status: Response::HTTP_OK
        );
    }

    #[Route('/station/{id}', name: 'update', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_PUT])]
    public function update(string $id, Payload $payload): Response
    {
        $station = $this->bus->execute(new Message\Update(
            $id,
            $payload->mandatory('name'),
            $payload->optional('description')
        ));

        return $this->createJsonResponse(
            data: $station,
            status: Response::HTTP_OK
        );
    }

    #[Route('station/{id}/users', name: 'list_users', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function users(string $id): Response
    {
        $users = $this->bus->execute(new Message\ListUsers($id));

        return $this->createJsonResponse(
            status: Response::HTTP_OK
        );
    }

    #[Route('/station/{id}', name: 'delete', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_DELETE])]
    public function delete(string $id): Response
    {
        $this->bus->execute(new Message\Delete($id));

        return $this->createJsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
