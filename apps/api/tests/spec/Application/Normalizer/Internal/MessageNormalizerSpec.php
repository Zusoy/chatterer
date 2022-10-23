<?php

namespace spec\Application\Normalizer\Internal;

use DateTimeImmutable;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\Message;
use PhpSpec\ObjectBehavior;

class MessageNormalizerSpec extends ObjectBehavior
{
    public function it_supports_only_message(Channel $channel, Message $message): void
    {
        $this->supports($channel->getWrappedObject())->shouldReturn(false);
        $this->supports($message->getWrappedObject())->shouldReturn(true);
    }

    public function it_normalizes_message(Message $message): void
    {
        $message->getIdentifier()->willReturn(
            new Identifier('ce0e20f7-d38b-465f-8732-5c8d8cb13e8e')
        );

        $message->getChannelIdentifier()->willReturn(
            new Identifier('91af6d0c-ddc9-40f4-9e10-7f68e5355f22')
        );

        $message->getContent()->willReturn('Hello all :)');
        $message->getCreatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));
        $message->getUpdatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));
        $message->getChannelName()->willReturn('General');

        $this->normalize($message)->shouldIterateLike([
            'id' => 'ce0e20f7-d38b-465f-8732-5c8d8cb13e8e',
            'content' => 'Hello all :)',
            'createdAt' => '2021-06-06',
            'updatedAt' => '2021-06-06',
            'channel' => [
                'id' => '91af6d0c-ddc9-40f4-9e10-7f68e5355f22',
                'name' => 'General'
            ]
        ]);
    }
}
