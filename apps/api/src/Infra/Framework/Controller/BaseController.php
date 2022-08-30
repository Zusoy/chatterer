<?php

namespace Infra\Framework\Controller;

use Application\Normalizer\Normalizer;
use Application\Serializer\Serializer;
use Domain\Bus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    public function __construct(
        protected Bus $bus,
        private Normalizer $normalizer,
        private Serializer $serializer
    ) {
    }

    final protected function createJsonResponse(
        mixed $data = null,
        int $status = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        $data = $this->normalizer->normalize($data);

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

        return $response;
    }
}
