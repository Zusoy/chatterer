<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Domain\Command\Invitation as Command;
use Domain\Identity\Identifier;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'invitation_')]
final class Invitation extends BaseController
{
    #[Route('invitation/{id}', name: 'delete', requirements: ['id' => Identifier::PATTERN], methods: [Request::METHOD_DELETE])]
    public function delete(string $id): Response
    {
        $this->bus->execute(new Command\Delete($id));

        return $this->createJsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
