<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes;

abstract class AbstractNotClonable
{
    private function __construct()
    {
        //
    }

    private function __clone()
    {
        //
    }
}
