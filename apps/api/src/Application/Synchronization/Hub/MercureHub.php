<?php

namespace Application\Synchronization\Hub;

use Application\Normalization\Normalizer;
use Application\Serialization\Serializer;
use Application\Synchronization\Hub;
use Application\Synchronization\Push;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

/**
 * @template T
 */
final class MercureHub implements Hub
{
    public const TOPIC_URI_PREFIX = 'https://chatterer.com/pushs/';

    /**
     * @var Push<T>[]
     */
    private array $pushs;

    /**
     * @param Normalizer<Push<T>> $normalizer
     */
    public function __construct(
        private HubInterface $hub,
        private Normalizer $normalizer,
        private Serializer $serializer
    ) {
        $this->pushs = [];
    }

    public function getPublicUrl(): string
    {
        return $this->hub->getPublicUrl();
    }

    /**
     * @param Push<T> $push
     */
    public function push(Push $push): void
    {
        $this->pushs[$push->getHash()] = $push;
    }

    public function send(): void
    {
        foreach ($this->pushs as $push) {
            $data = $this->normalizer->normalize($push);

            $this->hub->publish(
                new Update(
                    array_map(
                        fn ($topic) => $this->getUriForTopic($topic),
                        $push->getTopics()
                    ),
                    $this->serializer->serialize($data, Serializer::JSON_FORMAT)
                )
            );
        }

        $this->pushs = [];
    }

    public function getUriForTopic(string $topic): string
    {
        return self::TOPIC_URI_PREFIX.$topic;
    }
}
