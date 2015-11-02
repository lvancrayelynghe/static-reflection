<?php

namespace Benoth\StaticReflection\tests\ReflectionClassTests;

class ReflectionClassSimpleClassWithoutNamespaceTest extends ReflectionClassSimpleClassTest
{
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithoutNamespace/Classes/SimpleClass.php');
        $this->class = $this->index->getClass('SimpleClass');
    }

    public function testGetName()
    {
        $this->assertSame('SimpleClass', $this->class->getName());
    }

    public function testGetNamespaceName()
    {
        $this->assertSame('', $this->class->getNamespaceName());
    }

    public function testInNamespace()
    {
        $this->assertSame(false, $this->class->inNamespace());
    }

    public function testGetStartLine()
    {
        $this->assertSame(5, $this->class->getStartLine());
    }

    public function testGetStaticPropertyValueExceptionNotStatic()
    {
        $this->setExpectedException('ReflectionException', 'Class SimpleClass does not have a property named property1');

        $this->class->getStaticPropertyValue('property1');
    }

    public function testGetStaticPropertyValueExceptionDoesNotExist()
    {
        $this->setExpectedException('ReflectionException', 'Class SimpleClass does not have a property named property4');

        $this->class->getStaticPropertyValue('property4');
    }

    public function testSetStaticPropertyValueExceptionNotStatic()
    {
        $this->setExpectedException('ReflectionException', 'Class SimpleClass does not have a property named property1');

        $this->class->setStaticPropertyValue('property1', 'DefaultValue');
    }
}
