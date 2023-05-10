<?php

namespace Infra\Symfony;

use Infra\Symfony\DependencyInjection\Compiler\ReplaceMercureDataCollectorPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import("{$this->getProjectDir()}/config/parameters.yaml");
        $container->import("{$this->getProjectDir()}/config/{parameters}_$this->environment.yaml");

        $container->import("{$this->getProjectDir()}/config/{packages}/*.yaml");
        $container->import("{$this->getProjectDir()}/config/{packages}/$this->environment/*.yaml");

        $container->import("{$this->getProjectDir()}/config/services.yaml");
        $container->import("{$this->getProjectDir()}/config/{services}_$this->environment.yaml");
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import("{$this->getProjectDir()}/config/{routes}/$this->environment/*.yaml");
        $routes->import("{$this->getProjectDir()}/config/{routes}/*.yaml");
    }

    /**
     * {@inheritDoc}
     */
    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ReplaceMercureDataCollectorPass());
    }
}
