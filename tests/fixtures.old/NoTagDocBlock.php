<?php

namespace Benoth\StaticReflection\Tests\Fixtures;

/**
 * A class.
 */
class NoTagDocBlock
{
    /**
     * A constant.
     */
    const CONSTANT = null;

    /**
     * A private property.
     */
    private $privateProperty;

    /**
     * A protected property.
     */
    protected $protectedProperty;

    /**
     * A public property.
     */
    public $publicProperty;

    /**
     * A constructor.
     */
    public function __construct($var1)
    {
        //
    }

    /**
     * A private method.
     */
    private function privateMethod($var1)
    {
        //
    }

    /**
     * A protected method.
     */
    protected function protectedMethod($var1, $var2)
    {
        //
    }

    /**
     * A public method.
     */
    public function publicMethod($var1, $var2, $var3)
    {
        //
    }

    /**
     * A public method with typed parameters.
     */
    public function withParameters(\Exception $exception, array $array = [], $defString = 'default', $defNull = null)
    {
        //
    }
}
