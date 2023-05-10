<?php

namespace spec\Application\Normalization\Normalizer;

use Application\Normalization\Exception\NormalizerNotFoundException;
use Application\Normalization\Normalizer;
use PhpSpec\ObjectBehavior;
use stdClass;

class AggregateNormalizerSpec extends ObjectBehavior
{
    public function it_normalizes_supported_object(): void
    {
        $this->beConstructedWith([$this->getStdClassNormalizer()]);

        $this->normalize(new stdClass())->shouldReturn([
            'type' => 'stdClass'
        ]);
    }

    public function it_normalizes_mutliple_supported_objects(): void
    {
        $this->beConstructedWith([$this->getStdClassNormalizer()]);

        $this->normalize([new stdClass(), new stdClass()])->shouldIterateLike([
            [
                'type' => 'stdClass'
            ],
            [
                'type' => 'stdClass'
            ]
        ]);
    }

    public function it_throws_when_normalizer_not_found(): void
    {
        $this->beConstructedWith([]);

        $this->shouldThrow(NormalizerNotFoundException::class)->during('normalize', [
            new stdClass()
        ]);
    }

    private function getStdClassNormalizer(): Normalizer
    {
        return new class implements Normalizer
        {
            /**
             * {@inheritDoc}
             */
            public function supports(mixed $data): bool
            {
                return $data instanceof stdClass;
            }

            /**
             * {@inheritDoc}
             */
            public function normalize(mixed $data): array
            {
                return [
                    'type' => get_class($data)
                ];
            }
        };
    }
}
