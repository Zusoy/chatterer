<?php

declare(strict_types=1);

namespace spec\Application\Messaging;

use Application\Messaging\Map\InMemoryHandlerMap;
use Application\Messaging\Transaction\Transaction;
use Domain\Bus;
use Domain\Handler;
use Domain\Message;
use PhpSpec\ObjectBehavior;

class TransactionalMessageBusSpec extends ObjectBehavior
{
    public function it_is_initializable(Transaction $transaction): void
    {
        $handler1 = $this->createMockedHandler($this->createMockedMessage(), 'Hello World!');
        $handler2 = $this->createMockedHandler($this->createMockedMessage(), 'Hello World!');

        $this->beConstructedWith(
            new InMemoryHandlerMap([$handler1, $handler2]),
            $transaction
        );

        $this->shouldImplement(Bus::class);
        $this->shouldNotThrow()->duringInstantiation();
    }

    public function it_returns_the_supported_handler_result(Transaction $transaction): void
    {
        $message = $this->createMockedMessage();
        $handler1 = $this->createMockedHandler($message, 'Hello World !');
        $handler2 = $this->createMockedHandler($message, 'Bye !');

        $this->beConstructedWith(new InMemoryHandlerMap([$handler1, $handler2]), $transaction);

        $this->execute($message)->shouldReturn('Hello World !');
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
