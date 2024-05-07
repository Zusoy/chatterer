<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Command\Subject as Command;
use Domain\Identity\Identifier;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'subject_')]
final class Subject extends BaseController
{
    #[Route('forum/{forumId}/subjects', name: 'list', requirements: ['forumId' => Identifier::PATTERN], methods: [Request::METHOD_GET])]
    public function list(string $forumId): Response
    {
        /** @var iterable<\Domain\Model\Forum\Subject> */
        $subjects = $this->bus->execute(new Command\All($forumId));

        return $this->createJsonResponse(
            data: $subjects,
            status: Response::HTTP_OK
        );
    }

    #[Route('forum/{forumId}/subjects', name: 'create', requirements: ['forumId' => Identifier::PATTERN], methods: [Request::METHOD_POST])]
    public function create(string $forumId, Payload $payload): Response
    {
        /** @var \Domain\Model\Forum\Subject */
        $subject = $this->bus->execute(new Command\Create(
            title: (string) $payload->mandatory('title'),
            forumId: $forumId
        ));

        return $this->createJsonResponse(
            data: $subject,
            status: Response::HTTP_CREATED
        );
    }
}
