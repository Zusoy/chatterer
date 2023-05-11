<?php

declare(strict_types=1);

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Command\User as Command;
use Domain\Model\User as UserModel;
use Infra\Symfony\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'user_')]
final class User extends BaseController
{
    #[Route('/users', name: 'list', methods: [Request::METHOD_GET])]
    public function list(): Response
    {
        /** @var iterable<UserModel> */
        $users = $this->bus->execute(new Command\All());

        return $this->createJsonResponse(
            data: $users,
            status: Response::HTTP_OK
        );
    }

    #[Route('/users', name: 'create', methods: [Request::METHOD_POST])]
    public function create(Payload $payload): Response
    {
        /** @var UserModel */
        $user = $this->bus->execute(new Command\Create(
            firstname: (string) $payload->mandatory('firstname'),
            lastname: (string) $payload->mandatory('lastname'),
            email: (string) $payload->mandatory('email'),
            password: (string) $payload->mandatory('password'),
            isAdmin: (bool) $payload->optional('isAdmin', defaultValue: false)
        ));

        return $this->createJsonResponse(
            data: $user,
            status: Response::HTTP_CREATED
        );
    }

    #[Route('/register', name: 'register', methods: [Request::METHOD_POST])]
    public function register(Payload $payload): Response
    {
        /** @var UserModel */
        $user = $this->bus->execute(new Command\Register(
            firstname: (string) $payload->mandatory('firstname'),
            lastname: (string) $payload->mandatory('lastname'),
            email: (string) $payload->mandatory('email'),
            password: (string) $payload->mandatory('password')
        ));

        return $this->createJsonResponse(
            data: $user,
            status: Response::HTTP_CREATED
        );
    }
}
