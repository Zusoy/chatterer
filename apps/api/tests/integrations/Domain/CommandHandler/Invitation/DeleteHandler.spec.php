<?php

declare(strict_types=1);

use Domain\Command\Invitation\Delete;
use Domain\CommandHandler\Invitation\DeleteHandler;
use Domain\EventLog;
use Domain\Exception\ObjectNotFoundException;
use Domain\Model\Invitation;
use Domain\Model\Station;
use Domain\Repository\Invitations;

describe(DeleteHandler::class, function () {
    beforeEach(function () {
        $this->em->clear();
        $this->truncater->truncateAll();
        $this->events->clean();
    });

    given('invitations', fn () => $this->container->get(Invitations::class));
    given('events', fn () => $this->container->get(EventLog::class));

    it ('deletes invitation from database', function () {
        $station = new Station(name: 'Station', description: 'test');
        $this->em->persist($station);

        $invitation = new Invitation($station);
        $identifier = $invitation->getIdentifier();
        $this->em->persist($invitation);
        $this->em->flush();

        $command = new Delete(id: (string) $identifier);
        $this->bus->execute($command);

        $deletedInvitation = $this->invitations->find($identifier);

        expect(null === $deletedInvitation)->toBeTruthy();

        $events = $this->events->getSentEvents();
        expect(count($events))->toBe(1);

        expect($events[0])->toMatch(function (mixed $actual) use ($station, $invitation): bool {
            return $actual instanceof \Domain\Event\Invitation\Deleted &&
                $actual->invitation->getIdentifier() === $invitation->getIdentifier() &&
                $actual->station->getIdentifier() === $station->getIdentifier()
            ;
        });
    });

    it ('throws when invitation not found from database', function () {
        expect(fn () => $this->bus->execute(new Delete(
            id: 'a1bb4fa1-3a2a-4045-a66e-3435da68a00a'
        )))->toThrow(new ObjectNotFoundException('Invitation', 'a1bb4fa1-3a2a-4045-a66e-3435da68a00a'));
    });
});
