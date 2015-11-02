<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces;

interface InterfaceA
{
    const COMMON              = true;
    const COMMON_INTERFACE    = false;
    const CONSTANT_INTERFACEA = 12;

    public function __construct();

    public function publicMethodInterfaceA($var1);
}
