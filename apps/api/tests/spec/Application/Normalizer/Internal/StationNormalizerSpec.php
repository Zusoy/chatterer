<?php

namespace spec\Application\Normalizer\Internal;

use DateTimeImmutable;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Station;
use PhpSpec\ObjectBehavior;

class StationNormalizerSpec extends ObjectBehavior
{
    public function it_supports_only_station(Station $station, Channel $channel): void
    {
        $this->supports($station->getWrappedObject())->shouldReturn(true);
        $this->supports($channel->getWrappedObject())->shouldReturn(false);
    }

    public function it_normalizes_station(
        Station $station,
        Channel $channel1,
        Channel $channel2
    ): void {
        $station->getIdentifier()->willReturn(new Identifier('e97408f1-3e03-4e58-beb5-af6635cd75c0'));
        $station->getName()->willReturn('Station');
        $station->getDescription()->willReturn('Station description');
        $station->getCreatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));
        $station->getUpdatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));

        $channel1->getIdentifier()->willReturn(new Identifier('5c8d6e37-2f38-45b3-bc78-3660a3531655'));
        $channel1->getName()->willReturn('Channel One');
        $channel2->getIdentifier()->willReturn(new Identifier('5c8d6e37-2f38-45b3-bc78-af6635cd75c0'));
        $channel2->getName()->willReturn('Channel Two');

        $station->getChannels()->willReturn([$channel1, $channel2]);

        $this->normalize($station)->shouldIterateLike([
            'id' => 'e97408f1-3e03-4e58-beb5-af6635cd75c0',
            'name' => 'Station',
            'description' => 'Station description',
            'createdAt' => '2021-06-06',
            'updatedAt' => '2021-06-06',
            'channels' => [
                [
                    'id' => '5c8d6e37-2f38-45b3-bc78-3660a3531655',
                    'name' => 'Channel One'
                ],
                [
                    'id' => '5c8d6e37-2f38-45b3-bc78-af6635cd75c0',
                    'name' => 'Channel Two'
                ]
            ]
        ]);
    }
}
