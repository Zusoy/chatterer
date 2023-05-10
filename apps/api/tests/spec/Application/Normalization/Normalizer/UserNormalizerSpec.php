<?php

namespace spec\Application\Normalization\Normalizer;

use DateTimeImmutable;
use Domain\Identity\Identifier;
use Domain\Model\Channel;
use Domain\Model\User;
use PhpSpec\ObjectBehavior;

class UserNormalizerSpec extends ObjectBehavior
{
    public function it_supports_only_user(Channel $channel, User $user): void
    {
        $this->supports($channel->getWrappedObject())->shouldReturn(false);
        $this->supports($user->getWrappedObject())->shouldReturn(true);
    }

    public function it_normalizes_user(User $user): void
    {
        $user->getIdentifier()->willReturn(
            new Identifier('6d683ee5-5d60-4b67-8935-34b59cb834f9')
        );
        $user->getFirstname()->willReturn('John');
        $user->getLastname()->willReturn('Doe');
        $user->getEmail()->willReturn('john.doe@gmail.com');
        $user->getCreatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));
        $user->getUpdatedAt()->willReturn(new DateTimeImmutable('2021-06-06'));
        $user->isAdmin()->willReturn(false);

        $this->normalize($user)->shouldIterateLike([
            'id' => '6d683ee5-5d60-4b67-8935-34b59cb834f9',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@gmail.com',
            'isAdmin' => false,
            'createdAt' => '2021-06-06',
            'updatedAt' => '2021-06-06'
        ]);
    }
}
