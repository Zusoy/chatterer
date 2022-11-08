<?php

use Domain\Exception\ObjectAlreadyExistsException;
use Domain\Exception\ObjectNotFoundException;
use Domain\Handler\Station\InviteHandler;
use Domain\Message\Station\Invite;
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

        $message = new Invite(id: $station->getIdentifier());
        $this->bus->execute($message);

        /** @var Invitation */
        $invitation = $this->invitations->findByStation($station);

        expect($invitation === null)->toBeFalsy();
        expect($invitation->getStation())->toBeAnInstanceOf(Station::class);
    });

    it ('throws if station not found from database', function () {
        $message = new Invite(id: '493e66a5-e2e6-4f59-afc1-6fefcc679361');

        $closure = function () use ($message) {
            $this->bus->execute($message);
        };

        expect($closure)->toThrow(new ObjectNotFoundException('Station', '493e66a5-e2e6-4f59-afc1-6fefcc679361'));
    });

    it ('throws if station already have invitation', function () {
        $station = new Station(name: 'Station', description: null);
        $this->em->persist($station);

        $invitation = new Invitation($station);
        $this->em->persist($invitation);
        $this->em->flush();

        $message = new Invite(id: $station->getIdentifier());

        $closure = function () use ($message) {
            $this->bus->execute($message);
        };

        expect($closure)
            ->toThrow(new ObjectAlreadyExistsException('Invitation', $station->getIdentifier()));
    });
});
