<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits;

trait SimpleTrait
{
    public $property1    = 1;
    protected $property2 = 2;
    private $property3   = null;

    public function method1(&$var1)
    {
        //
    }

    protected function method2($var1 = null)
    {
        //
    }

    private function method3(array $var1 = array())
    {
        //
    }
}
