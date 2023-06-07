<?php

declare(strict_types=1);

namespace Infra\Symfony\Controller;

use Application\Normalization\Normalizer;
use Application\Serialization\Serializer;
use Application\Synchronization\Hub;
use Domain\Bus;
use Domain\Model\User;
use Domain\Security\UserProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class BaseController
{
    private const DISCOVERY_LINK_TEMPLATE = '<%s>; rel="%s"';

    /**
     * @param Normalizer<mixed> $normalizer
     */
    public function __construct(
        protected readonly Bus $bus,
        private readonly Normalizer $normalizer,
        private readonly Serializer $serializer,
        private readonly Hub $hub,
        private readonly UserProvider $userProvider
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

    /**
     * @throws UnauthorizedHttpException if no user connected
     */
    final protected function getCurrentUser(): User
    {
        if (!$user = $this->userProvider->getCurent()) {
            throw new UnauthorizedHttpException('Basic');
        }

        return $user;
    }
}
