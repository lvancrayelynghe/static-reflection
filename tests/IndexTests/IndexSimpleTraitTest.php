<?php

namespace Benoth\StaticReflection\tests\IndexTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class IndexSimpleTraitTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php');
    }

    public function testGetReflections()
    {
        $this->assertCount(1, $this->index->getReflections());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->index->getReflections());
    }

    public function testGetClasses()
    {
        $this->assertCount(0, $this->index->getClasses());
    }

    public function testGetClassLikes()
    {
        $this->assertCount(1, $this->index->getClassLikes());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->index->getClassLikes());
    }

    public function testGetInterfaces()
    {
        $this->assertCount(0, $this->index->getInterfaces());
    }

    public function testGetTraits()
    {
        $this->assertCount(1, $this->index->getTraits());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->index->getTraits());
    }

    public function testGetFunctionLikes()
    {
        $this->assertCount(3, $this->index->getFunctionLikes());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->index->getFunctionLikes());
    }

    public function testGetFunctions()
    {
        $this->assertCount(0, $this->index->getFunctions());
    }

    public function testGetClass()
    {
        $this->assertSame(null, $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\SimpleTrait'));
        $this->assertSame(null, $this->index->getClass('SimpleTrait'));
    }

    public function testGetInterface()
    {
        $this->assertSame(null, $this->index->getInterface('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\SimpleInterface'));
        $this->assertSame(null, $this->index->getInterface('SimpleInterface'));
    }

    public function testGetTrait()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->index->getTrait('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\SimpleTrait'));
        $this->assertSame(null, $this->index->getTrait('SimpleTrait'));
    }

    public function testGetFunction()
    {
        $this->assertSame(null, $this->index->getFunction('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\SimpleTrait'));
        $this->assertSame(null, $this->index->getFunction('SimpleTrait'));
    }
}
