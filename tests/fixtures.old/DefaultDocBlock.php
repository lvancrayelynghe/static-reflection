<?php

namespace Benoth\StaticReflection\Tests\Fixtures;

class DefaultDocBlock
{
    /**
     *
     */
    const CONSTANT = null;

    /**
     * [$privateProperty description].
     *
     * @type [type]
     */
    private $privateProperty;

    /**
     * [$protectedProperty description].
     *
     * @type [type]
     */
    protected $protectedProperty;

    /**
     * [$publicProperty description].
     *
     * @type [type]
     */
    public $publicProperty;

    /**
     * [__construct description].
     *
     * @param [type] $var1 [description]
     */
    public function __construct($var1)
    {
        //
    }

    /**
     * [privateMethod description].
     *
     * @param [type] $var1 [description]
     * @param [type] $var1 [description]
     *
     * @return [type] [description]
     */
    private function privateMethod($var1)
    {
        //
    }

    /**
     * [protectedMethod description].
     *
     * @param string $var1 A short description
     * @param bool   $var2 A short description
     *
     * @return [type] [description]
     */
    protected function protectedMethod($var1, $var2)
    {
        //
    }

    /**
     * [publicMethod description].
     *
     * @param string $var1 A short description
     * @param bool   $var2 A short description
     * @param array  $var3 A short description
     *
     * @return [type] [description]
     */
    public function publicMethod($var1, $var2, $var3)
    {
        //
    }

    /**
     * [withParameters description].
     *
     * @param \Exception $exception [description]
     * @param array      $array     [description]
     * @param string     $default   [description]
     *
     * @return [type] [description]
     */
    public function withParameters(\Exception $exception, array $array = [], $default = 'default')
    {
        //
    }
}
