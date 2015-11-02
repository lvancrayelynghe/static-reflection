<?php

define('SIMPLE_CONSTANT', 123456789);

class SimpleClass implements \Iterator
{
    const CONSTANT = false;

    public $property1    = 1;
    protected $property2 = false;
    private $property3   = 'string';

    public function __construct($magicConstant = __FILE__, $simpleConstant = SIMPLE_CONSTANT, $classConstant = SimpleClass::CONSTANT)
    {
        //
    }

    /**
     * A simple DocBlock.
     */
    public function method1($var1)
    {
        //
    }

    protected function method2(&$var1 = null)
    {
        //
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
