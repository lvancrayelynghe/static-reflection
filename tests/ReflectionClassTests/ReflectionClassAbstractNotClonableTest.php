<?php

namespace Benoth\StaticReflection\tests\ReflectionClassTests;

use Benoth\StaticReflection\Reflection\Reflection;
use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionClassAbstractNotClonableTest extends AbstractTestCase
{
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Classes/AbstractNotClonable.php');
        $this->class = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractNotClonable');
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
        $this->assertSame(true, $this->class->isAbstract());
    }

    public function testIsFinal()
    {
        $this->assertSame(false, $this->class->isFinal());
    }

    public function testGetMethods()
    {
        $this->assertCount(2, $this->class->getMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods());
        $this->assertArrayHasKey('__construct', $this->class->getMethods());
        $this->assertArrayHasKey('__clone', $this->class->getMethods());
    }

    public function testGetPublicMethods()
    {
        $this->assertCount(0, $this->class->getMethods(Reflection::IS_PUBLIC));
    }

    public function testGetProtectedMethods()
    {
        $this->assertCount(0, $this->class->getMethods(Reflection::IS_PROTECTED));
    }

    public function testGetPrivateMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('__construct', $this->class->getMethods(Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('__clone', $this->class->getMethods(Reflection::IS_PRIVATE));
    }

    public function testGetProtectedAndPrivateMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('__construct', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('__clone', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
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
        $this->assertCount(2, $this->class->getSelfMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getSelfMethods());
    }

    public function testGetMethodConstruct()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethod('__construct'));
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

    public function testImplementsInterface()
    {
        $this->assertSame(false, $this->class->implementsInterface('Iterator'));
        $this->assertSame(false, $this->class->implementsInterface('IteratorAggregate'));
    }

    public function testIsClonable()
    {
        $this->assertSame(false, $this->class->isCloneable());
    }

    public function testIsInstantiable()
    {
        $this->assertSame(false, $this->class->isInstantiable());
    }

    public function testIsIterateable()
    {
        $this->assertSame(false, $this->class->isIterateable());
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
