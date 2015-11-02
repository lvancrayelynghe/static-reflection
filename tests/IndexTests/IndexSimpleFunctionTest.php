<?php

namespace Benoth\StaticReflection\tests\IndexTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class IndexSimpleFunctionTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Functions/SimpleFunction.php');
    }

    public function testGetReflections()
    {
        $this->assertCount(1, $this->index->getReflections());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionFunction', $this->index->getReflections());
    }

    public function testGetClasses()
    {
        $this->assertCount(0, $this->index->getClasses());
    }

    public function testGetClassLikes()
    {
        $this->assertCount(0, $this->index->getClassLikes());
    }

    public function testGetInterfaces()
    {
        $this->assertCount(0, $this->index->getInterfaces());
    }

    public function testGetTraits()
    {
        $this->assertCount(0, $this->index->getTraits());
    }

    public function testGetFunctionLikes()
    {
        $this->assertCount(1, $this->index->getFunctionLikes());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionFunction', $this->index->getFunctionLikes());
    }

    public function testGetFunctions()
    {
        $this->assertCount(1, $this->index->getFunctions());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionFunction', $this->index->getFunctions());
    }

    public function testGetClass()
    {
        $this->assertSame(null, $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Functions\SimpleFunction'));
        $this->assertSame(null, $this->index->getClass('SimpleFunction'));
    }

    public function testGetInterface()
    {
        $this->assertSame(null, $this->index->getInterface('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\SimpleInterface'));
        $this->assertSame(null, $this->index->getInterface('SimpleInterface'));
    }

    public function testGetTrait()
    {
        $this->assertSame(null, $this->index->getTrait('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Functions\SimpleFunction'));
        $this->assertSame(null, $this->index->getTrait('SimpleFunction'));
    }

    public function testGetFunction()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionFunction', $this->index->getFunction('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Functions\SimpleFunction'));
        $this->assertSame(null, $this->index->getFunction('SimpleFunction'));
    }
}
