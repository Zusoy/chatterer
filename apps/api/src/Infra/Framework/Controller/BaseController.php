<?php

namespace Infra\Framework\Controller;

use Application\Normalizer\Normalizer;
use Application\Serializer\Serializer;
use Application\Synchronization\Hub;
use Domain\Bus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    private const DISCOVERY_LINK_TEMPLATE = '<%s>; rel="%s"';

    public function __construct(
        protected Bus $bus,
        private Normalizer $normalizer,
        private Serializer $serializer,
        private Hub $hub
    ) {
    }

    /**
     * @param array<string,string> $headers
     */
    final protected function createJsonResponse(
        mixed $data = null,
        int $status = Response::HTTP_OK,
        ?string $discoveryTopic = null,
        array $headers = [],
        bool $normalize = true
    ): JsonResponse {
        if ($normalize) {
            $data = $this->normalizer->normalize($data);
        }

        $response = new JsonResponse(
            data: $this->serializer->serialize($data, Serializer::JSON_FORMAT),
            status: $status,
            headers: $headers,
            json: true
        );

        if (is_countable($data)) {
            $response->headers->add([
                'X-Total-Count' => count($data),
            ]);
        }

        if ($discoveryTopic) {
            $response->headers->add(
                [
                    'Link' => implode(', ', [
                        sprintf(self::DISCOVERY_LINK_TEMPLATE, $this->hub->getPublicUrl(), 'mercure'),
                        sprintf(self::DISCOVERY_LINK_TEMPLATE, $this->hub->getUriForTopic($discoveryTopic), 'self'),
                    ]),
                ]
            );
        }

        return $response;
    }
}
