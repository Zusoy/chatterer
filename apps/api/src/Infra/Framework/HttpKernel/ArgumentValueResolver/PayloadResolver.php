<?php

namespace Infra\Framework\HttpKernel\ArgumentValueResolver;

use Application\HTTP\Payload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class PayloadResolver implements ArgumentValueResolverInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return Payload::class === $argument->getType();
    }

    /**
     * {@inheritDoc}
     *
     * @return iterable<Payload>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield new Payload($request);
    }
}
