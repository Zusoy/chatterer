<?php

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Identity\Identifier;
use Infra\Framework\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Domain\Message\Message as DomainMessage;

final class Message extends BaseController
{
    #[Route('channel/{channelId}/messages', name: 'create', requirements: ['channelId' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function create(string $channelId, Payload $payload): Response
    {
        $message = $this->bus->execute(new DomainMessage\Create(
            channelId: $channelId,
            content: $payload->mandatory('content')
        ));

        return $this->createJsonResponse(
            data: $message,
            status: Response::HTTP_CREATED
        );
    }
}
