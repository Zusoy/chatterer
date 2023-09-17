<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Command\Forum as Command;
use Domain\Identity\Identifier;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'forum_')]
final class Forum extends BaseController
{
    #[Route('station/{stationId}/forums', name: 'list', requirements: ['stationId' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function list(string $stationId): Response
    {
        /** @var iterable<\Domain\Model\Forum\Forum> */
        $forums = $this->bus->execute(new Command\All($stationId));

        return $this->createJsonResponse(
            data: $forums,
            status: Response::HTTP_OK
        );
    }

    #[Route('station/{stationId}/forums', name: 'create', requirements: ['stationId' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function create(string $stationId, Payload $payload): Response
    {
        /** @var \Domain\Model\Forum\Forum */
        $forum = $this->bus->execute(new Command\Create(
            name: (string) $payload->mandatory('name'),
            stationId: $stationId
        ));

        return $this->createJsonResponse(
            data: $forum,
            status: Response::HTTP_CREATED
        );
    }
}
