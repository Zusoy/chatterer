<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManagerInterface;
use Domain\Bus;
use Infra\Doctrine\Truncater;
use Infra\Framework\Kernel;
use Kahlan\Filter\Filters;
use Kahlan\Matcher;
use Test\Integrations\Matcher\Assert\ToFailAssertionsAtPaths;

$commandLine = $this->commandLine();

$commandLine->option('reporter', 'default', 'verbose');
$commandLine->option('spec', 'default', __DIR__ . '/tests/integrations');

Filters::apply($this, 'run', function (callable $next) {
    $kernel = new Kernel('test', true);
    $kernel->boot();
    $container = $kernel->getContainer()->get('test.service_container');

    $scope = $this->suite()->root()->scope();
    $scope->container = $container;

    /** @var EntityManagerInterface */
    $em = $container->get(EntityManagerInterface::class);

    // set helper services
    $scope->em = $em;
    $scope->bus = $container->get(Bus::class);
    $scope->truncater = new Truncater($em->getConnection());

    return $next();
});

Filters::apply($this, 'matchers', function (callable $next) {
    Matcher::register('toFailAssertionsAtPaths', ToFailAssertionsAtPaths::class);

    return $next();
});
