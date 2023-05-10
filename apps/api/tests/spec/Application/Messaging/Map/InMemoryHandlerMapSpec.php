<?php

declare(strict_types=1);

namespace spec\Application\Messaging\Map;

use Application\Messaging\Exception\HandlerNotFoundException;
use Application\Messaging\Map\HandlerMap;
use Assert\AssertionFailedException;
use Domain\Handler;
use Domain\Message;
use PhpSpec\ObjectBehavior;

class InMemoryHandlerMapSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->beConstructedWith([
            $this->createMockedHandler($this->createMockedMessage(), 'Hello'),
            $this->createMockedHandler($this->createMockedMessage(), 'Bye')
        ]);

        $this->shouldImplement(HandlerMap::class);
        $this->shouldNotThrow()->duringInstantiation();
    }

    public function it_throws_when_handler_not_callable(): void
    {
        $invalidHandler = new class implements Handler {
            public function supports(Message $message): bool
            {
                return true;
            }
        };

        $this->beConstructedWith([
            $this->createMockedHandler($this->createMockedMessage(), 'Hello'),
            $invalidHandler
        ]);

        $this->shouldThrow(AssertionFailedException::class)->duringInstantiation();
    }

    public function it_provides_handler_from_message(): void
    {
        $message1 = $this->createMockedMessage();
        $message2 = $this->createMockedMessage();

        $handler1 = $this->createMockedHandler($message1, 'Hello');
        $handler2 = $this->createMockedHandler($message2, 'Bye');

        $this->beConstructedWith([$handler1, $handler2]);

        $this->getHandler($message2)->shouldBeLike($handler2);
    }

    public function it_throws_exception_when_handler_not_found(): void
    {
        $message1 = $this->createMockedMessage();
        $message2 = $this->createMockedMessage();
        $message3 = $this->createMockedMessage();

        $handler1 = $this->createMockedHandler($message1, 'Hello');
        $handler2 = $this->createMockedHandler($message2, 'Bye');

        $this->beConstructedWith([$handler1, $handler2]);

        $this
            ->shouldThrow(HandlerNotFoundException::class)
            ->during('getHandler', [$message3])
        ;
    }

    private function createMockedMessage(): Message
    {
        return new class implements Message
        {
        };
    }

    private function createMockedHandler(Message $supportedMessage, mixed $invocationResult): Handler
    {
        return new class($supportedMessage, $invocationResult) implements Handler
        {
            public function __construct(private Message $supportedMessage, private mixed $invocationResult)
            {
            }

            /**
             * {@inheritDoc}
             */
            public function supports(Message $message): bool
            {
                return $this->supportedMessage === $message;
            }

            public function __invoke(Message $message): mixed
            {
                return $this->invocationResult;
            }
        };
    }
}
