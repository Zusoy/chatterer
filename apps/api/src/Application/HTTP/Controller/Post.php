<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Command\Post as Command;
use Domain\Identity\Identifier;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'post_')]
final class Post extends BaseController
{
    #[Route('subject/{subjectId}/posts', name: 'list', requirements: ['subjectId' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function list(string $subjectId): Response
    {
        /** @var iterable<\Domain\Model\Forum\Post> */
        $posts = $this->bus->execute(new Command\All($subjectId));

        return $this->createJsonResponse(
            data: $posts,
            status: Response::HTTP_OK
        );
    }

    #[Route('subject/{subjectId}/posts', name: 'create', requirements: ['subjectId' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function create(string $subjectId, Payload $payload): Response
    {
        /** @var \Domain\Model\Forum\Post */
        $post = $this->bus->execute(new Command\Create(
            content: (string) $payload->mandatory('content'),
            authorId: (string) $this->getCurrentUser()->getIdentifier(),
            subjectId: $subjectId
        ));

        return $this->createJsonResponse(
            data: $post,
            status: Response::HTTP_CREATED
        );
    }
}
