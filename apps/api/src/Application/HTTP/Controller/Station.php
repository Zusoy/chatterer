<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Command\Station as Command;
use Domain\Identity\Identifier;
use Domain\Model\Invitation;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'station_')]
final class Station extends BaseController
{
    #[Route('/stations', name: 'list', methods: [Request::METHOD_GET])]
    public function list(): Response
    {
        $stations = $this->bus->execute(new Command\All(
            userId: (string) $this->getCurrentUser()->getIdentifier()
        ));

        return $this->createJsonResponse(
            data: $stations,
            discoveryTopic: 'station/list'
        );
    }

    #[Route('/station/{id}', name: 'get', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function get(string $id): Response
    {
        $station = $this->bus->execute(new Command\Get($id));

        return $this->createJsonResponse(
            data: $station,
            discoveryTopic: "station/{$id}"
        );
    }

    #[Route('/stations', name: 'create', methods: [Request::METHOD_POST])]
    public function create(Payload $payload): Response
    {
        $station = $this->bus->execute(new Command\Create(
            name: (string) $payload->mandatory('name'),
            description: (string) $payload->optional('description')
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
        $invitation = $this->bus->execute(new Command\Invite($id));

        return $this->createJsonResponse(
            data: $invitation,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('/stations/join', name: 'join', methods: [Request::METHOD_POST])]
    public function join(Payload $payload): Response
    {
        $station = $this->bus->execute(new Command\Join(
            userId: (string) $this->getCurrentUser()->getIdentifier(),
            invitationToken: $payload->mandatory('token')
        ));

        return $this->createJsonResponse(
            data: $station,
            status: Response::HTTP_OK
        );
    }

    #[Route('/station/{id}', name: 'update', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_PUT])]
    public function update(string $id, Payload $payload): Response
    {
        $station = $this->bus->execute(new Command\Update(
            $id,
            name: (string) $payload->mandatory('name'),
            description: (string) $payload->optional('description')
        ));

        return $this->createJsonResponse(
            data: $station,
            status: Response::HTTP_OK
        );
    }

    #[Route('station/{id}/users', name: 'list_users', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function users(string $id): Response
    {
        $users = $this->bus->execute(new Command\ListUsers($id));

        return $this->createJsonResponse(
            data: $users,
            status: Response::HTTP_OK
        );
    }

    #[Route('/station/{id}', name: 'delete', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_DELETE])]
    public function delete(string $id): Response
    {
        $this->bus->execute(new Command\Delete($id));

        return $this->createJsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
