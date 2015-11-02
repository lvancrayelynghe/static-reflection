<?php

namespace Benoth\StaticReflection\tests\ReflectionClassTests;

use Benoth\StaticReflection\Reflection\Reflection;
use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionClassAbstractStaticFinalMethods extends AbstractTestCase
{
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Classes/AbstractStaticFinalMethods.php');
        $this->class = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractStaticFinalMethods');
    }

    public function testGetMethods()
    {
        $this->assertCount(3, $this->class->getMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods());
    }

    public function testGetPublicMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('finalPublicMethod', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('publicStaticMethod', $this->class->getMethods(Reflection::IS_PUBLIC));
    }

    public function testGetProtectedMethods()
    {
        $this->assertCount(1, $this->class->getMethods(Reflection::IS_PROTECTED));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PROTECTED));
        $this->assertArrayHasKey('abstractProtectedMethod', $this->class->getMethods(Reflection::IS_PROTECTED));
    }

    public function testGetPrivateMethods()
    {
        $this->assertCount(0, $this->class->getMethods(Reflection::IS_PRIVATE));
    }

    public function testGetFinalMethods()
    {
        $this->assertCount(1, $this->class->getMethods(Reflection::IS_FINAL));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_FINAL));
        $this->assertArrayHasKey('finalPublicMethod', $this->class->getMethods(Reflection::IS_FINAL));
    }

    public function testGetAbstractMethods()
    {
        $this->assertCount(1, $this->class->getMethods(Reflection::IS_ABSTRACT));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('abstractProtectedMethod', $this->class->getMethods(Reflection::IS_ABSTRACT));
    }

    public function testGetStaticMethods()
    {
        $this->assertCount(1, $this->class->getMethods(Reflection::IS_STATIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_STATIC));
        $this->assertArrayHasKey('publicStaticMethod', $this->class->getMethods(Reflection::IS_STATIC));
    }

    public function testGetFinalPublicMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('finalPublicMethod', $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('publicStaticMethod', $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC));
    }

    public function testGetAbstractFinalPublicMethods()
    {
        $this->assertCount(3, $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC | Reflection::IS_ABSTRACT));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC | Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('finalPublicMethod', $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC | Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('publicStaticMethod', $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC | Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('abstractProtectedMethod', $this->class->getMethods(Reflection::IS_FINAL | Reflection::IS_PUBLIC | Reflection::IS_ABSTRACT));
    }

    public function testGetProperties()
    {
        $this->assertCount(3, $this->class->getProperties());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties());
        $this->assertArrayHasKey('publicStaticProp', $this->class->getProperties());
        $this->assertArrayHasKey('protectedStaticProp', $this->class->getProperties());
        $this->assertArrayHasKey('privateStaticProp', $this->class->getProperties());
    }

    public function testGetStaticProperties()
    {
        $this->assertCount(3, $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertSame($this->class->getStaticProperties(), $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertArrayHasKey('publicStaticProp', $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertArrayHasKey('protectedStaticProp', $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertArrayHasKey('privateStaticProp', $this->class->getProperties(Reflection::IS_STATIC));
    }

    public function testGetStaticPropertyValueDefault()
    {
        $this->assertSame('DefaultValue', $this->class->getStaticPropertyValue('property2', 'DefaultValue'));
    }

    public function testGetStaticPropertyValue()
    {
        $this->assertSame(1.1, $this->class->getStaticPropertyValue('publicStaticProp', 'DefaultValue'));
        $this->assertSame(1.1, $this->class->getStaticPropertyValue('publicStaticProp'));
        $this->assertSame(array(), $this->class->getStaticPropertyValue('protectedStaticProp', 'DefaultValue'));
        $this->assertSame(array(), $this->class->getStaticPropertyValue('protectedStaticProp'));
        $this->assertSame(null, $this->class->getStaticPropertyValue('privateStaticProp', 'DefaultValue'));
        $this->assertSame(null, $this->class->getStaticPropertyValue('privateStaticProp'));
    }

    public function testSetStaticPropertyValue()
    {
        $this->assertSame(null, $this->class->setStaticPropertyValue('publicStaticProp', 'NewDefaultValue'));
        $this->assertSame('NewDefaultValue', $this->class->getStaticPropertyValue('publicStaticProp', 'DefaultValue'));
        $this->assertSame('NewDefaultValue', $this->class->getStaticPropertyValue('publicStaticProp'));
    }

    public function testSetStaticPropertyValueExceptionNotPublic()
    {
        $this->setExpectedException('ReflectionException', 'Class Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractStaticFinalMethods does not have a property named protectedStaticProp');

        $this->class->setStaticPropertyValue('protectedStaticProp', 'DefaultValue');
    }
}
