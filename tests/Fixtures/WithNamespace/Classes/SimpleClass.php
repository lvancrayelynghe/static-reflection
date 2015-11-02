<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes;

class SimpleClass implements \Iterator
{
    const CONSTANT = false;

    public $property1    = 1;
    protected $property2 = false;
    private $property3   = 'string';

    public function __construct()
    {
        //
    }

    /**
     * A simple DocBlock.
     */
    public function method1($var1)
    {
        static $a = 0, $b = 15;
    }

    protected function method2(&$var1 = null)
    {
        static $c = array('bool' => true, 'float' => 1.2, 'array' => [1 => 1, 'string' => 'text', 'dateTimeObject' => new \DateTime()]);
    }

    private function method3(array $var1 = array())
    {
        static $d;

        foreach($var1 as $item) {
            yield $item / 2;
        }

        yield from [3, 4];
    }
}
