<?php

namespace Application\HTTP\Controller;

use Domain\Bus;
use Domain\Message as Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Test
{
    public function __construct(private Bus $bus)
    {
    }

    #[Route('/test', name: 'test', methods: ['GET'])]
    public function test(): Response
    {
        $msg = $this->bus->execute(new Message\Test('test'));

        return new Response($msg);
    }
}
