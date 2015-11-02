<?php

namespace Benoth\StaticReflection\Tests\Fixtures;

trait NoDocBlockTrait
{
    const CONSTANT = null;

    private $privateProperty;

    protected $protectedProperty;

    public $publicProperty;

    public function __construct($var1)
    {
        //
    }

    private function privateMethod($var1)
    {
        //
    }

    protected function protectedMethod($var1, $var2)
    {
        //
    }

    public function publicMethod($var1, $var2, $var3)
    {
        //
    }

    public function withParameters(\Exception $exception, array $array = [], $default = 'default')
    {
        //
    }
}
