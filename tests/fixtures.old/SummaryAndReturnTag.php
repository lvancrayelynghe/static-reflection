<?php

namespace Benoth\StaticReflection\Tests\Fixtures;

/**
 * A class.
 *
 * @license
 */
class SummaryAndReturnTag
{
    const CONSTANT = null;

    private $privateProperty;

    protected $protectedProperty;

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
     *
     * @return string A string
     * @return string Another string
     */
    private function privateMethod($var1)
    {
        //
    }

    /**
     * A protected method.
     *
     * @return int An integer
     */
    protected function protectedMethod($var1, $var2)
    {
        //
    }

    /**
     * A public method.
     *
     * @return array An array
     */
    public function publicMethod($var1, $var2, $var3)
    {
        //
    }

    /**
     * A public method with typed parameters.
     *
     * @return \Exception An Exception
     */
    public function withParameters(\Exception $exception, array $array = [], $defString = 'default', $defNull = null)
    {
        //
    }
}
