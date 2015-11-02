<?php

namespace Benoth\StaticReflection\tests\ReflectionClassTests;

use Benoth\StaticReflection\Reflection\Reflection;
use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionClassSimpleClassTest extends AbstractTestCase
{
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Classes/SimpleClass.php');
        $this->class = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\SimpleClass');
    }

    public function testGetName()
    {
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\SimpleClass', $this->class->getName());
    }

    public function testGetShortName()
    {
        $this->assertSame('SimpleClass', $this->class->getShortName());
    }

    public function testGetNamespaceName()
    {
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes', $this->class->getNamespaceName());
    }

    public function testInNamespace()
    {
        $this->assertSame(true, $this->class->inNamespace());
    }

    public function testGetStartLine()
    {
        $this->assertSame(5, $this->class->getStartLine());
    }

    public function testGetParent()
    {
        $this->assertSame(null, $this->class->getParent());
    }

    public function testGetParentClass()
    {
        $this->assertSame(null, $this->class->getParentClass());
    }

    public function testGetExtension()
    {
        $this->assertSame(null, $this->class->getExtension());
    }

    public function testGetExtensionName()
    {
        $this->assertSame(false, $this->class->getExtensionName());
    }

    public function testIsInternal()
    {
        $this->assertSame(false, $this->class->isInternal());
    }

    public function testIsUserDefined()
    {
        $this->assertSame(true, $this->class->isUserDefined());
    }

    public function testIsClass()
    {
        $this->assertSame(true, $this->class->isClass());
    }

    public function testIsInterface()
    {
        $this->assertSame(false, $this->class->isInterface());
    }

    public function testIsTrait()
    {
        $this->assertSame(false, $this->class->isTrait());
    }

    public function testIsAbstract()
    {
        $this->assertSame(false, $this->class->isAbstract());
    }

    public function testIsFinal()
    {
        $this->assertSame(false, $this->class->isFinal());
    }

    public function testGetConstants()
    {
        $this->assertCount(1, $this->class->getConstants());
        $this->assertArrayHasKey('CONSTANT', $this->class->getConstants());
        $this->assertSame(false, $this->class->getConstants()['CONSTANT']);
    }

    public function testGetSelfConstants()
    {
        $this->assertCount(1, $this->class->getSelfConstants());
        $this->assertArrayHasKey('CONSTANT', $this->class->getSelfConstants());
        $this->assertSame(false, $this->class->getSelfConstants()['CONSTANT']);
    }

    public function testGetConstant()
    {
        $this->assertSame(false, $this->class->getConstant('CONSTANT'));
        $this->assertSame(false, $this->class->getConstant('OTHER_CONSTANT'));
    }

    public function testHasConstant()
    {
        $this->assertSame(true, $this->class->hasConstant('CONSTANT'));
        $this->assertSame(false, $this->class->hasConstant('OTHER_CONSTANT'));
    }

    public function testGetProperties()
    {
        $this->assertCount(3, $this->class->getProperties());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties());
        $this->assertArrayHasKey('property1', $this->class->getProperties());
        $this->assertArrayHasKey('property2', $this->class->getProperties());
        $this->assertArrayHasKey('property3', $this->class->getProperties());
    }

    public function testSelfGetProperties()
    {
        $this->assertCount(3, $this->class->getSelfProperties());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getSelfProperties());
        $this->assertArrayHasKey('property1', $this->class->getSelfProperties());
        $this->assertArrayHasKey('property2', $this->class->getSelfProperties());
        $this->assertArrayHasKey('property3', $this->class->getSelfProperties());
    }

    public function testGetStaticProperties()
    {
        $this->assertCount(0, $this->class->getStaticProperties());
    }

    public function testGetProperty()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperty('property1'));
        $this->assertSame('property1', $this->class->getProperty('property1')->getName());
    }

    public function testGetPropertyException()
    {
        $this->setExpectedException('ReflectionException', 'Property propertyUnknown does not exist');

        $this->class->getProperty('propertyUnknown');
    }

    public function testGetPublicProperties()
    {
        $this->assertCount(1, $this->class->getProperties(Reflection::IS_PUBLIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('property1', $this->class->getProperties(Reflection::IS_PUBLIC));
    }

    public function testGetProtectedProperties()
    {
        $this->assertCount(1, $this->class->getProperties(Reflection::IS_PROTECTED));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PROTECTED));
        $this->assertArrayHasKey('property2', $this->class->getProperties(Reflection::IS_PROTECTED));
    }

    public function testGetPrivateProperties()
    {
        $this->assertCount(1, $this->class->getProperties(Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('property3', $this->class->getProperties(Reflection::IS_PRIVATE));
    }

    public function testGetProtectedAndPrivateProperties()
    {
        $this->assertCount(2, $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('property2', $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('property3', $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
    }

    public function testGeStaticProperties()
    {
        $this->assertCount(0, $this->class->getProperties(Reflection::IS_STATIC));
    }

    public function testHasProperty()
    {
        $this->assertSame(false, $this->class->hasProperty('$property1'));
        $this->assertSame(true, $this->class->hasProperty('property1'));
        $this->assertSame(true, $this->class->hasProperty('property2'));
        $this->assertSame(true, $this->class->hasProperty('property3'));
        $this->assertSame(false, $this->class->hasProperty('property4'));
    }

    public function testGetDefaultProperties()
    {
        $this->assertCount(3, $this->class->getDefaultProperties());
        $this->assertSame(['property1' => 1, 'property2' => false, 'property3' => 'string'], $this->class->getDefaultProperties());
    }

    public function testGetStaticPropertyValueDefault()
    {
        $this->assertSame('DefaultValue', $this->class->getStaticPropertyValue('property2', 'DefaultValue'));
    }

    public function testGetStaticPropertyValueExceptionNotStatic()
    {
        $this->setExpectedException('ReflectionException', 'Class Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\SimpleClass does not have a property named property1');

        $this->class->getStaticPropertyValue('property1');
    }

    public function testGetStaticPropertyValueExceptionDoesNotExist()
    {
        $this->setExpectedException('ReflectionException', 'Class Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\SimpleClass does not have a property named property4');

        $this->class->getStaticPropertyValue('property4');
    }

    public function testSetStaticPropertyValueExceptionNotStatic()
    {
        $this->setExpectedException('ReflectionException', 'Class Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\SimpleClass does not have a property named property1');

        $this->class->setStaticPropertyValue('property1', 'DefaultValue');
    }

    public function testGetMethods()
    {
        $this->assertCount(4, $this->class->getMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods());
    }

    public function testGetPublicMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('__construct', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('method1', $this->class->getMethods(Reflection::IS_PUBLIC));
    }

    public function testGetProtectedMethods()
    {
        $this->assertCount(1, $this->class->getMethods(Reflection::IS_PROTECTED));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PROTECTED));
        $this->assertArrayHasKey('method2', $this->class->getMethods(Reflection::IS_PROTECTED));
    }

    public function testGetPrivateMethods()
    {
        $this->assertCount(1, $this->class->getMethods(Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('method3', $this->class->getMethods(Reflection::IS_PRIVATE));
    }

    public function testGetProtectedAndPrivateMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('method2', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('method3', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
    }

    public function testGeFinalMethods()
    {
        $this->assertCount(0, $this->class->getMethods(Reflection::IS_FINAL));
    }

    public function testGeAbstractMethods()
    {
        $this->assertCount(0, $this->class->getMethods(Reflection::IS_ABSTRACT));
    }

    public function testGeStaticMethods()
    {
        $this->assertCount(0, $this->class->getMethods(Reflection::IS_STATIC));
    }

    public function testGetSelfMethods()
    {
        $this->assertCount(4, $this->class->getSelfMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getSelfMethods());
    }

    public function testGetMethodConstruct()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethod('__construct'));
    }

    public function testGetMethodMethod1()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethod('method1'));
    }

    public function testGetMethodException()
    {
        $this->setExpectedException('ReflectionException', 'Method __construct() does not exist');

        $this->class->getMethod('__construct()');
    }

    public function testGetConstructor()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getConstructor());
        $this->assertSame('__construct', $this->class->getConstructor()->getName());
    }

    public function testHasMethodConstruct()
    {
        $this->assertSame(true, $this->class->hasMethod('__construct'));
    }

    public function testGetDocComment()
    {
        $this->assertSame("/**\n     * A simple DocBlock.\n     */", $this->class->getMethod('method1')->getDocComment());
    }

    public function testImplementsInterface()
    {
        $this->assertSame(true, $this->class->implementsInterface('Iterator'));
        $this->assertSame(false, $this->class->implementsInterface('IteratorAggregate'));
    }

    public function testIsClonable()
    {
        $this->assertSame(true, $this->class->isCloneable());
    }

    public function testIsInstantiable()
    {
        $this->assertSame(true, $this->class->isInstantiable());
    }

    public function testIsIterateable()
    {
        $this->assertSame(true, $this->class->isIterateable());
    }

    public function testNewInstance()
    {
        $this->setExpectedException('ReflectionException', 'StaticReflection can\'t create instances');

        $this->class->newInstance();
    }

    public function testNewInstanceArgs()
    {
        $this->setExpectedException('ReflectionException', 'StaticReflection can\'t create instances');

        $this->class->newInstanceArgs([1, 2]);
    }

    public function testNewInstanceWithoutConstructor()
    {
        $this->setExpectedException('ReflectionException', 'StaticReflection can\'t create instances');

        $this->class->newInstanceWithoutConstructor();
    }
}
