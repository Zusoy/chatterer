<?php

namespace Test\Acceptance;

abstract class Helper
{
    /**
     * Called before the current scenario
     */
    public abstract function beforeScenario(): void;
}
