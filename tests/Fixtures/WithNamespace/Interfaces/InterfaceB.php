<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces;

interface InterfaceB
{
    const COMMON              = null;
    const COMMON_INTERFACE    = 42;
    const CONSTANT_INTERFACEB = 'another string';

    public function publicMethodInterfaceB($var1, $var2 = false);
}
