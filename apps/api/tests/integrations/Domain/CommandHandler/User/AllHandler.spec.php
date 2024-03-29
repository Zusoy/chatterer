<?php

declare(strict_types=1);

use Domain\Command\User\All;
use Domain\CommandHandler\User\AllHandler;
use Domain\Model\User;
use Domain\Repository\Users;

describe(AllHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('users', fn () => $this->container->get(Users::class));

    it ('retrieves all users from database', function () {
        $firstUser = new User(
            firstname: 'Hello',
            lastname: 'World',
            email: 'h.w@gmail.com',
            password: 'hello'
        );

        $secondUser = new User(
            firstname: 'Other',
            lastname: 'User',
            email: 'o.u@gmail.com',
            password: 'hello'
        );

        $this->em->persist($firstUser);
        $this->em->persist($secondUser);
        $this->em->flush();

        $command = new All();
        $users = $this->bus->execute($command);

        expect($users)->toHaveLength(2);
    });
});
