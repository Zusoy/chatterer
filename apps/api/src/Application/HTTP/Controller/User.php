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
