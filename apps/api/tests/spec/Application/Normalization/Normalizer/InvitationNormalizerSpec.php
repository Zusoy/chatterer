<?php

declare(strict_types=1);

namespace spec\Application\Normalization\Normalizer;

use DateTimeImmutable;
use Domain\Identity\Identifier;
use Domain\Model\Invitation;
use Domain\Model\Link\LinkToken;
use Domain\Model\Station;
use PhpSpec\ObjectBehavior;

class InvitationNormalizerSpec extends ObjectBehavior
{
    public function it_supports_only_invitation_link(Invitation $invitation, Station $station): void
    {
        $this->supports($station->getWrappedObject())->shouldReturn(false);
        $this->supports($invitation->getWrappedObject())->shouldReturn(true);
    }

    public function it_normalize_invitation_link(Invitation $invitation): void
    {
        $invitation->getIdentifier()->willReturn(
            new Identifier('5c8d6e37-2f38-45b3-bc78-3660a3531655')
        );

        $invitation->getStationIdentifier()->willReturn(
            new Identifier('5be4f01c-6491-4c55-8d2d-93253945103d')
        );

        $token = LinkToken::generate();
        $invitation->getToken()->willReturn($token);

        $invitation->getCreatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));
        $invitation->getUpdatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));

        $this->normalize($invitation)->shouldIterateLike([
            'id' => '5c8d6e37-2f38-45b3-bc78-3660a3531655',
            'station' => '5be4f01c-6491-4c55-8d2d-93253945103d',
            'token' => (string) $token,
            'createdAt' => '2021-06-06',
            'updatedAt' => '2021-06-06',
        ]);
    }
}
