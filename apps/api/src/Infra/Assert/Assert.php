<?php

namespace Infra\Assert;

use Assert\Assert as BaseAssert;

class Assert extends BaseAssert
{
    protected static $assertionClass = Assertion::class;
}
