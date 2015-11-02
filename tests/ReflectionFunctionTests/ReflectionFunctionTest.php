<?php

namespace Benoth\StaticReflection\Tests\ReflectionFunctions;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionFunctionTest extends AbstractTestCase
{
    protected $function;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Functions/SimpleFunction.php');
        $this->function = $this->index->getFunction('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Functions\SimpleFunction');
    }

    public function testGetFileName()
    {
        $this->assertSame($this->fixturesPath.'/WithNamespace/Functions/SimpleFunction.php', $this->function->getFileName());
    }

    public function testGetParameters()
    {
        $this->assertCount(1, $this->function->getParameters());

        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->function->getParameters());
    }
}
