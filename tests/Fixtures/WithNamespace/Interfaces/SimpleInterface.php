<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces;

interface SimpleInterface
{
	const CONSTANT = false;

    public function __construct();

    public function method1($var1);

    protected function method2($var1 = null);

    private function method3(array $var1 = array());
}
