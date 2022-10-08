<?php

namespace spec\Application\Synchronization\Hub;

use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use PhpSpec\ObjectBehavior;

class MockedHubSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldImplement(Hub::class);
    }

    public function it_registers_and_sends_actions(Push $push1, Push $push2, Push $push3): void
    {
        $this->push($push1);
        $this->push($push2);

        $this->getQueue()->shouldIterateLike([$push1, $push2]);
        $this->getSentPushes()->shouldIterateLike([]);

        $this->send();

        $this->push($push3);

        $this->getQueue()->shouldIterateLike([$push3]);
        $this->getSentPushes()->shouldIterateLike([$push1, $push2]);

        $this->clean();

        $this->getQueue()->shouldIterateLike([]);
        $this->getSentPushes()->shouldIterateLike([]);
    }
}
