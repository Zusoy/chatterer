<?php

declare(strict_types=1);

namespace Test\Acceptance;

abstract class Helper
{
    /**
     * Called before the current scenario
     */
    public abstract function beforeScenario(): void;
}
