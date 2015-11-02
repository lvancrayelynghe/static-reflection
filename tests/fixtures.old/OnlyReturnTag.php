<?php

namespace Benoth\StaticReflection\Tests\Fixtures;

/**
 * @license https://opensource.org/licenses/MIT
 */
class OnlyReturnTag
{
    const CONSTANT = null;

    private $privateProperty;

    protected $protectedProperty;

    public $publicProperty;

    /**
     * @return string A constructor
     */
    public function __construct($var1)
    {
        //
    }

    /**
     * @return string A string
     */
    private function privateMethod($var1)
    {
        return 'test';

        return array('test' => 1);

        return ['test' => 'test'];

        return;

        return true;

        return 1.1;
        $closure = function () {
            return 'closure';
        };
        uasort($var1, function () {
            return false;
        });

        return 12;

        return new TestClass('Error Processing Request');

        return (true ? true : false);

        return _A_CONSTANT_;

        return __FILE__;

        return function ($test) { return true;};

        return;
    }

    /**
     * @return OnlyReturnTag|void
     */
    protected function protectedMethod($var1, $var2)
    {
        //
    }

    /**
     * @return
     */
    public function publicMethod($var1, $var2, $var3)
    {
        //
    }

    /**
     * @return \Exception An Exception
     */
    public function withParameters(\Exception $exception, array $array = [], $defString = 'default', $defNull = null)
    {
        throw new Exception('Error Processing Request');
        throw new Sub\Sub\UnknownException('Error Processing Request');
        throw new RuntimeException('Error Processing Request');

        if (!$exception || is_null($exception)) {
            foreach ($array as $key => $value) {
                if ($value) {
                    throw new NestedException('Error Processing Request');
                }
            }
        }

        for ($i = 0; $i < 12; ++$i) {
            if (1 || 2 && false != true) {
                return $this->protectedMethod($var1, $var2);
            }
        }
    }
}
