<?php

namespace spec\Application\Normalizer\Internal;

use DateTimeImmutable;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Station;
use PhpSpec\ObjectBehavior;

class ChannelNormalizerSpec extends ObjectBehavior
{
    public function it_supports_only_channel(Channel $channel, Station $station): void
    {
        $this->supports($station->getWrappedObject())->shouldReturn(false);
        $this->supports($channel->getWrappedObject())->shouldReturn(true);
    }

    public function it_normalizes_channel(Channel $channel): void
    {
        $channel->getIdentifier()->willReturn(new Identifier('5c8d6e37-2f38-45b3-bc78-3660a3531655'));
        $channel->getStationIdentifier()->willReturn(new Identifier('5be4f01c-6491-4c55-8d2d-93253945103d'));
        $channel->getStationName()->willReturn('Station');
        $channel->getName()->willReturn('Random');
        $channel->getDescription()->willReturn('for random conversations !');
        $channel->getCreatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));
        $channel->getUpdatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));

        $this->normalize($channel)->shouldIterateLike([
            'id' => '5c8d6e37-2f38-45b3-bc78-3660a3531655',
            'name' => 'Random',
            'description' => 'for random conversations !',
            'createdAt' => '2021-06-06',
            'updatedAt' => '2021-06-06',
            'station' => [
                'id' => '5be4f01c-6491-4c55-8d2d-93253945103d',
                'name' => 'Station'
            ]
        ]);
    }
}
