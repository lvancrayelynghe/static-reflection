<?php

namespace Benoth\StaticReflection\tests\IndexTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class IndexSimpleInterfaceTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Interfaces/SimpleInterface.php');
    }

    public function testGetReflections()
    {
        $this->assertCount(1, $this->index->getReflections());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->index->getReflections());
    }

    public function testGetClasses()
    {
        $this->assertCount(0, $this->index->getClasses());
    }

    public function testGetClassLikes()
    {
        $this->assertCount(1, $this->index->getClassLikes());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->index->getClassLikes());
    }

    public function testGetInterfaces()
    {
        $this->assertCount(1, $this->index->getInterfaces());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->index->getInterfaces());
    }

    public function testGetTraits()
    {
        $this->assertCount(0, $this->index->getTraits());
    }

    public function testGetFunctionLikes()
    {
        $this->assertCount(4, $this->index->getFunctionLikes());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->index->getFunctionLikes());
    }

    public function testGetFunctions()
    {
        $this->assertCount(0, $this->index->getFunctions());
    }

    public function testGetClass()
    {
        $this->assertSame(null, $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\SimpleInterface'));
        $this->assertSame(null, $this->index->getClass('SimpleInterface'));
    }

    public function testGetInterface()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->index->getInterface('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\SimpleInterface'));
        $this->assertSame(null, $this->index->getInterface('SimpleInterface'));
    }

    public function testGetTrait()
    {
        $this->assertSame(null, $this->index->getTrait('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\SimpleInterface'));
        $this->assertSame(null, $this->index->getTrait('SimpleInterface'));
    }

    public function testGetFunction()
    {
        $this->assertSame(null, $this->index->getFunction('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\SimpleInterface'));
        $this->assertSame(null, $this->index->getFunction('SimpleInterface'));
    }
}
