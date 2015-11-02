<?php

namespace Benoth\StaticReflection\Tests\Fixtures;

class OnlyParamTag
{
    const CONSTANT = null;

    private $privateProperty;

    protected $protectedProperty;

    public $publicProperty;

    /**
     * @param string $var1 Parameter description
     */
    public function __construct($var1)
    {
        //
    }

    /**
     * @param string $var1 Parameter description
     */
    private function privateMethod($var1)
    {
        //
    }

    /**
     * @param string $var1 Parameter description
     * @param string $var2 Parameter description
     */
    protected function protectedMethod($var1, $var2)
    {
        //
    }

    /**
     * @param string $var1 Parameter description
     * @param string $var2 Parameter description
     * @param string $var3 Parameter description
     */
    public function publicMethod($var1, $var2, $var3)
    {
        //
    }

    /**
     * @param \Exception $exception Parameter description
     * @param array      $array     Parameter description
     * @param string     $defString Parameter description
     * @param string     $defNull   Parameter description
     */
    public function withParameters(\Exception $exception, array $array = [], $defString = 'default', $defNull = null)
    {
        //
    }
}
