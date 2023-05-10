<?php

namespace spec\Application\Synchronization\Hub;

use Application\Normalization\Normalizer;
use Application\Serialization\Serializer;
use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Mercure\HubInterface;

class MercureHubSpec extends ObjectBehavior
{
    public function let(HubInterface $hub, Normalizer $normalizer, Serializer $serializer): void
    {
        $this->beConstructedWith($hub, $normalizer, $serializer);
    }

    public function it_is_initializable(): void
    {
        $this->shouldImplement(Hub::class);
    }

    public function it_registers_and_sends_actions(
        HubInterface $hub,
        Serializer $serializer,
        Normalizer $normalizer,
        Push $push1,
        Push $push2
    ): void {
        $push1->getTopics()->willReturn(['foo/list', 'foo/1']);
        $push1->getHash()->willReturn('azerty1');
        $push2->getTopics()->willReturn(['bar/list']);
        $push2->getHash()->willReturn('azerty2');

        $normalizer->normalize($push1)->willReturn(['type' => 'puhs1']);
        $normalizer->normalize($push2)->willReturn(['type' => 'push2']);

        $serializer->serialize(['type' => 'puhs1'], Serializer::JSON_FORMAT)->willReturn('"whatever"');
        $serializer->serialize(['type' => 'push2'], Serializer::JSON_FORMAT)->willReturn('"whatever"');

        $hub->publish(Argument::any())->willReturn('')->shouldBeCalledTimes(2);

        $this->push($push1);
        $this->push($push2);

        $this->send();
    }

    public function it_registers_only_the_last_action_of_the_same_type(
        HubInterface $hub,
        Serializer $serializer,
        Normalizer $normalizer,
        Push $push1,
        Push $push2
    ): void {
        $push1->getTopics()->willReturn(['bar/list']);
        $push1->getHash()->willReturn('azerty1');
        $push2->getTopics()->willReturn(['bar/list']);
        $push2->getHash()->willReturn('azerty1');

        $normalizer->normalize($push1)->shouldNotBeCalled();

        $normalizer->normalize($push2)
            ->willReturn(['type' => 'push2'])
            ->shouldBeCalledTimes(1);

        $serializer->serialize(['type' => 'push2'], Serializer::JSON_FORMAT)
            ->willReturn('"whatever"')
            ->shouldBeCalledTimes(1);

        $hub->publish(Argument::any())->willReturn('')->shouldBeCalledTimes(1);

        $this->push($push1);
        $this->push($push2);

        $this->send();
    }
}
