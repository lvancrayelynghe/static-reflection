<?php

namespace Benoth\StaticReflection\tests\ReflectionClassTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionClassBetterDateTimeTest extends AbstractTestCase
{
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithoutNamespace/Classes/BetterDateTime.php');
        $this->class = $this->index->getClass('BetterDateTime');
    }

    public function testGetName()
    {
        $this->assertSame('BetterDateTime', $this->class->getName());
    }

    public function testGetShortName()
    {
        $this->assertSame('BetterDateTime', $this->class->getShortName());
    }

    public function testGetParent()
    {
        $this->assertSame('DateTime', $this->class->getParent());
    }

    public function testGetParentClass()
    {
        $this->assertInstanceOf('ReflectionClass', $this->class->getParentClass());
    }

    public function testGetConstants()
    {
        $this->assertCount(11, $this->class->getConstants());
        $this->assertArrayHasKey('ISO8601', $this->class->getConstants());
        $this->assertArrayHasKey('RFC1036', $this->class->getConstants());
        $this->assertArrayHasKey('W3C', $this->class->getConstants());
    }

    public function testGetSelfConstants()
    {
        $this->assertCount(0, $this->class->getSelfConstants());
    }

    public function testGetConstant()
    {
        $this->assertSame("Y-m-d\TH:i:sP", $this->class->getConstant('ATOM'));
        $this->assertSame('l, d-M-Y H:i:s T', $this->class->getConstant('COOKIE'));
    }

    public function testHasConstant()
    {
        $this->assertSame(true, $this->class->hasConstant('ATOM'));
        $this->assertSame(true, $this->class->hasConstant('COOKIE'));
        $this->assertSame(false, $this->class->hasConstant('OTHER_CONSTANT'));
    }

    public function testGetProperties()
    {
        $this->assertCount(0, $this->class->getProperties());
    }

    public function testSelfGetProperties()
    {
        $this->assertCount(0, $this->class->getSelfProperties());
    }

    public function testGetStaticProperties()
    {
        $this->assertCount(0, $this->class->getStaticProperties());
    }

    public function testGetDefaultProperties()
    {
        $this->assertCount(0, $this->class->getDefaultProperties());
        $this->assertSame([], $this->class->getDefaultProperties());
    }

    public function testGetMethods()
    {
        $this->assertCount(18, $this->class->getMethods());
        $this->assertArrayHasKey('format', $this->class->getMethods());
        $this->assertArrayHasKey('add', $this->class->getMethods());
        $this->assertArrayHasKey('sub', $this->class->getMethods());
        $this->assertArrayHasKey('setISODate', $this->class->getMethods());
    }

    public function testGetSelfMethods()
    {
        $this->assertCount(2, $this->class->getSelfMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getSelfMethods());
    }

    public function testGetMethodConstruct()
    {
        $this->assertInstanceOf('ReflectionMethod', $this->class->getMethod('__construct'));
    }

    public function testHasMethodConstruct()
    {
        $this->assertSame(true, $this->class->hasMethod('__construct'));
    }

    public function testGetMethodMethodStaticReflection()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethod('format'));
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethod('add'));
    }

    public function testGetMethodMethodNativeReflection()
    {
        $this->assertInstanceOf('ReflectionMethod', $this->class->getMethod('sub'));
        $this->assertInstanceOf('ReflectionMethod', $this->class->getMethod('setISODate'));
    }
}
