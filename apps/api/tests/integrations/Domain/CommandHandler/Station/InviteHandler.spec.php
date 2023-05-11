<?php

declare(strict_types=1);

use Domain\Command\Station\Invite;
use Domain\CommandHandler\Station\InviteHandler;
use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Invitation;
use Domain\Model\Station;
use Domain\Repository\Invitations;

describe(InviteHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
    });

    given('invitations', fn () => $this->container->get(Invitations::class));

    it ('generates invitation link token', function () {
        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);
        $this->em->flush();

        $command = new Invite(id: (string) $station->getIdentifier());
        $this->bus->execute($command);

        /** @var Invitation */
        $invitation = $this->invitations->findByStation($station);

        expect($invitation === null)->toBeFalsy();
        expect($invitation->getStation())->toBeAnInstanceOf(Station::class);
    });

    it ('throws if station not found from database', function () {
        $command = new Invite(id: '493e66a5-e2e6-4f59-afc1-6fefcc679361');

        $closure = function () use ($command) {
            $this->bus->execute($command);
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Station', '493e66a5-e2e6-4f59-afc1-6fefcc679361'));
    });

    it ('throws if station already have invitation', function () {
        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);

        $invitation = new Invitation($station);
        $this->em->persist($invitation);
        $this->em->flush();

        $command = new Invite(id: (string) $station->getIdentifier());

        $closure = function () use ($command) {
            $this->bus->execute($command);
        };

        expect($closure)
            ->toThrow(new ObjectAlreadyExistsException('Invitation', (string) $station->getIdentifier()));
    });
});
