<?php

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Identity\Identifier;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Domain\Message\Message as DomainMessage;

#[Route(name: 'message_')]
final class Message extends BaseController
{
    #[Route('channel/{channelId}/messages', name: 'list', requirements: ['channelId' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function list(string $channelId): Response
    {
        $messages = $this->bus->execute(new DomainMessage\All($channelId));

        return $this->createJsonResponse(
            data: $messages,
            status: Response::HTTP_OK,
            discoveryTopic: "message/list/{$channelId}"
        );
    }

    #[Route('channel/{channelId}/messages', name: 'create', requirements: ['channelId' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function create(string $channelId, Payload $payload): Response
    {
        $message = $this->bus->execute(new DomainMessage\Create(
            authorId: $this->getCurrentUser()->getIdentifier(),
            channelId: $channelId,
            content: $payload->mandatory('content')
        ));

        return $this->createJsonResponse(
            data: $message,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('message/{id}', name: 'delete', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_DELETE])]
    public function delete(string $id): Response
    {
        $this->bus->execute(new DomainMessage\Delete($id));

        return $this->createJsonResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
