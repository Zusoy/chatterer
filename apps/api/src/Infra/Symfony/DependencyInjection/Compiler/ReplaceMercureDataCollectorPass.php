<?php

namespace Infra\Symfony\DependencyInjection\Compiler;

use Infra\Symfony\DataCollector\HubDataCollector;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

final class ReplaceMercureDataCollectorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        try {
            $innerCollector = $container->getDefinition('data_collector.mercure');

            $container
                ->setDefinition('data_collector.mercure.inner', $innerCollector)
                ->clearTag('data_collector');

            $container
                ->register(HubDataCollector::class, HubDataCollector::class)
                ->addArgument(new Reference('data_collector.mercure.inner'))
                ->addTag('data_collector', [
                    'template' => '@Mercure/Collector/mercure.html.twig',
                    'id' => 'mercure',
                ]);

            $container->setAlias('data_collector.mercure', HubDataCollector::class);
        } catch (ServiceNotFoundException) {
        }
    }
}
