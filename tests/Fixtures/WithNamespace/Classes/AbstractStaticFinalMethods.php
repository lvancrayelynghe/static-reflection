<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes;

abstract class AbstractStaticFinalMethods
{
    public static $publicStaticProp = 1.1;
    protected static $protectedStaticProp = array();
    private static $privateStaticProp;

    abstract protected function abstractProtectedMethod()
    {
        //
    }

    final public function finalPublicMethod()
    {
        //
    }

    public static function publicStaticMethod()
    {
        //
    }
}
