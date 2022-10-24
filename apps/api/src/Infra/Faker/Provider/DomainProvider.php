<?php

namespace Infra\Faker\Provider;

use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\Station;
use Faker\Generator;
use Faker\Provider\Base;

final class DomainProvider extends Base
{
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    public function station(): Station
    {
        return new Station(
            name: $this->generator->company(),
            description: $this->generator->boolean(75)
                ? $this->generator->sentence(10)
                : null
        );
    }

    /**
     * @param Station[] $stations
     */
    public function channel(array $stations): Channel
    {
        /** @var Station */
        $station = $this->randomRelation($stations, nullable: false);

        $channel = new Channel(
            station: $station,
            name: $this->generator->text(maxNbChars: 8),
            description: $this->generator->boolean(75)
                ? $this->generator->sentence(10)
                : null
        );

        return $channel;
    }

    /**
     * @param Channel[] $channels
     */
    public function message(array $channels): Message
    {
        /** @var Channel */
        $channel = $this->randomRelation($channels, nullable: false);

        $message = new Message(
            content: $this->generator->text(maxNbChars: 100),
            channel: $channel
        );

        return $message;
    }

    /**
     * @template T
     *
     * @param T[] $collection
     *
     * @return ?T
     */
    private function randomRelation(array $collection, bool $nullable = false)
    {
        if (0 === count($collection)) {
            return null;
        }

        return $this->generator->boolean($nullable ? 75 : 100)
            ? $this->generator->randomElement($collection)
            : null
        ;
    }
}
