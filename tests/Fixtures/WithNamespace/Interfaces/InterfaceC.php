<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces;

use DateTime;

interface InterfaceC extends InterfaceB
{
	const COMMON = 12;
	const COMMON_INTERFACE = 58;
	const CONSTANT_INTERFACEC = 'another other string';

    public function __construct();

    public function publicMethodInterfaceC(&$var1, $var2 = false, DateTime $var3 = true);
}
