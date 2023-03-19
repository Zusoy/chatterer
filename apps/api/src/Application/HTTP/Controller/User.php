<?php

namespace Application\HTTP\Controller;

use Application\HTTP\Payload;
use Domain\Message\User as Message;
use Domain\Model\User as UserModel;
use Infra\Framework\Controller\BaseController;
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
        $users = $this->bus->execute(new Message\All());

        return $this->createJsonResponse(
            data: $users,
            status: Response::HTTP_OK
        );
    }

    #[Route('/me', name: 'me', methods: [Request::METHOD_GET])]
    public function me(): Response
    {
        return $this->createJsonResponse(
            data: $this->getCurrentUser(),
            status: Response::HTTP_OK
        );
    }

    #[Route('/users', name: 'create', methods: [Request::METHOD_POST])]
    public function create(Payload $payload): Response
    {
        /** @var UserModel */
        $user = $this->bus->execute(new Message\Create(
            firstname: $payload->mandatory('firstname'),
            lastname: $payload->mandatory('lastname'),
            email: $payload->mandatory('email'),
            password: $payload->mandatory('password'),
            isAdmin: $payload->optional('isAdmin', defaultValue: false)
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
        $user = $this->bus->execute(new Message\Register(
            firstname: $payload->mandatory('firstname'),
            lastname: $payload->mandatory('lastname'),
            email: $payload->mandatory('email'),
            password: $payload->mandatory('password')
        ));

        return $this->createJsonResponse(
            data: $user,
            status: Response::HTTP_CREATED
        );
    }
}
