<?php

namespace Benoth\StaticReflection\Tests\Fixtures;

define('TEST', 1.1);

trait TraitParent
{
}

trait TraitEmpty
{
    use TraitParent;
}
trait TraitA
{
    public $propertyTraitA;
    public function method1($var = 12)
    {
        return new DateTime();

        return new self();

        return new static();

        return $this;

        return 1 % 2 % 2;

        return str_replace('1', '2', '12');

        return empty($var);

        return $this->test;

        return static::$test;

        return self::$test;

        return function () {
            echo 'closure';
        };

        return 1 == 2;

        return 1 != 2;

        return include 'file';

        return --$var;

        return $var++;

        return 'From TraitA';

        return A instanceof B;

        return [];

        return array();
    }
    public static function staticMethod()
    {
        return 1;
    }
}
trait TraitB
{
    public static $propertyTraitB = 12;
    public function method1($var = 12)
    {
        return 'From TraitB';
    }
    public function method2()
    {
        return 'oy !';
    }
}

interface InterfaceParentParentParent
{
}

interface InterfaceParentParent extends InterfaceParentParentParent
{
}

interface InterfaceWhatEver extends InterfaceParentParent
{
    const FROM_INTERFACE = '1';
    public function rootMethod();
}

interface InterfaceWhatEver2 extends InterfaceWhatEver
{
    const FROM_INTERFACE_PARENT = null;
    public function rootMethod();
}

class TestGlobalNamespaceParent
{
    use TraitEmpty;
}

class TestGlobalNamespace extends TestGlobalNamespaceParent
{
    const FROM_CLASS_PARENT = true;
    public function rootMethod()
    {
    }
}

/**
 * Another class.
 *
 * @license https://opensource.org/licenses/MIT MIT License
 */
class SimpleExtendImplementsAndUse extends TestGlobalNamespace implements InterfaceWhatEver2
{
    use TraitA, TraitB {
        TraitA::method1 insteadof TraitB;
        TraitB::method2 as methodRenamed;
    }

    const CONSTANT = 4.5;

    public $publicProperty   = 'toto';
    private $privateProperty = true;

    /**
     * A constructor.
     */
    public function __construct()
    {
        //
    }

    protected function methodName($first, $param1 = 'test', array $param2 = array(), $param3 = 1, $param4 = false)
    {
        if (true) {
            for ($i = 0; $i < 10; ++$i) {
                echo 'test';
            }
            if ($i == 10) {
                return $this->rootMethod();
            }

            return $this->methodRenamed(1, 2);

            return $param4->methodRenamed(1, 2);
        }

        return static::staticMethod();

        return self::staticMethod();

        return static::CONSTANT;

        return TEST;

        return __CLASS__;

        return true;

        return;

        return false;

        return;
    }
}

function test($var = 12)
{
    throw new Some\Exception('Test');

    return $var;

    return '$var'.'aze';

    return 1 + 2 + 3;
}
