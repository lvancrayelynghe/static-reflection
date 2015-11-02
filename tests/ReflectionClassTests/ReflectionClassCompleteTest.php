<?php

namespace Benoth\StaticReflection\tests\ReflectionClassTests;

use Benoth\StaticReflection\Reflection\Reflection;
use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionClassCompleteTest extends AbstractTestCase
{
    protected $class;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Traits/TraitA.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Traits/TraitB.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Traits/TraitC.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Interfaces/SimpleInterface.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Interfaces/InterfaceA.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Interfaces/InterfaceB.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Interfaces/InterfaceC.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Classes/AbstractStaticFinalMethods.php');
        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Classes/ClassComplete.php');
        $this->class = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\ClassComplete');
    }

    public function testGetParent()
    {
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractStaticFinalMethods', $this->class->getParent());
    }

    public function testGetParentClass()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionClass', $this->class->getParentClass());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractStaticFinalMethods', $this->class->getParentClass()->getName());
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
        $this->assertSame(true, $this->class->isFinal());
    }

    public function testGetConstants()
    {
        $this->assertCount(6, $this->class->getConstants());
        $this->assertArrayHasKey('COMMON', $this->class->getConstants());
        $this->assertArrayHasKey('FROM_CLASS', $this->class->getConstants());
        $this->assertArrayHasKey('COMMON_INTERFACE', $this->class->getConstants());
        $this->assertArrayHasKey('CONSTANT_INTERFACEA', $this->class->getConstants());
        $this->assertArrayHasKey('CONSTANT_INTERFACEC', $this->class->getConstants());
        $this->assertArrayHasKey('CONSTANT_INTERFACEB', $this->class->getConstants());
        $this->assertSame(666, $this->class->getConstants()['COMMON']);
        $this->assertSame('from class', $this->class->getConstants()['FROM_CLASS']);
        $this->assertSame(58, $this->class->getConstants()['COMMON_INTERFACE']);
        $this->assertSame(12, $this->class->getConstants()['CONSTANT_INTERFACEA']);
        $this->assertSame('another other string', $this->class->getConstants()['CONSTANT_INTERFACEC']);
        $this->assertSame('another string', $this->class->getConstants()['CONSTANT_INTERFACEB']);
    }

    public function testGetSelfConstants()
    {
        $this->assertCount(2, $this->class->getSelfConstants());
        $this->assertArrayHasKey('COMMON', $this->class->getSelfConstants());
        $this->assertArrayHasKey('FROM_CLASS', $this->class->getSelfConstants());
        $this->assertSame(666, $this->class->getSelfConstants()['COMMON']);
        $this->assertSame('from class', $this->class->getSelfConstants()['FROM_CLASS']);
    }

    public function testGetConstant()
    {
        $this->assertSame(false, $this->class->getConstant('CONSTANT'));
        $this->assertSame(false, $this->class->getConstant('OTHER_CONSTANT'));
        $this->assertSame('from class', $this->class->getConstant('FROM_CLASS'));
        $this->assertSame('another other string', $this->class->getConstant('CONSTANT_INTERFACEC'));
    }

    public function testHasConstant()
    {
        $this->assertSame(false, $this->class->hasConstant('CONSTANT'));
        $this->assertSame(false, $this->class->hasConstant('OTHER_CONSTANT'));
        $this->assertSame(true, $this->class->hasConstant('FROM_CLASS'));
        $this->assertSame(true, $this->class->hasConstant('CONSTANT_INTERFACEA'));
        $this->assertSame(true, $this->class->hasConstant('CONSTANT_INTERFACEB'));
        $this->assertSame(true, $this->class->hasConstant('CONSTANT_INTERFACEC'));
    }

    public function testGetProperties()
    {
        $this->assertCount(13, $this->class->getProperties());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties());
        $this->assertArrayHasKey('publicStaticPropComplete', $this->class->getProperties());
        $this->assertArrayHasKey('publicStaticProp', $this->class->getProperties());
        $this->assertArrayHasKey('protectedStaticProp', $this->class->getProperties());
        $this->assertArrayHasKey('privateStaticProp', $this->class->getProperties());
        $this->assertArrayHasKey('property1', $this->class->getProperties());
        $this->assertArrayHasKey('property2', $this->class->getProperties());
        $this->assertArrayHasKey('property3', $this->class->getProperties());
        $this->assertArrayHasKey('staticPropertyTraitA', $this->class->getProperties());
        $this->assertArrayHasKey('property1TraitA', $this->class->getProperties());
        $this->assertArrayHasKey('property2TraitA', $this->class->getProperties());
        $this->assertArrayHasKey('property3TraitA', $this->class->getProperties());
        $this->assertArrayHasKey('staticPropertyTraitB', $this->class->getProperties());
        $this->assertArrayHasKey('property1TraitB', $this->class->getProperties());

        $this->assertSame('ClassComplete', $this->class->getProperties()['publicStaticPropComplete']->getDeclaringClass()->getShortName());
        $this->assertSame('AbstractStaticFinalMethods', $this->class->getProperties()['publicStaticProp']->getDeclaringClass()->getShortName());
        $this->assertSame('AbstractStaticFinalMethods', $this->class->getProperties()['protectedStaticProp']->getDeclaringClass()->getShortName());
        $this->assertSame('AbstractStaticFinalMethods', $this->class->getProperties()['privateStaticProp']->getDeclaringClass()->getShortName());
        $this->assertSame('SimpleTrait', $this->class->getProperties()['property1']->getDeclaringClass()->getShortName());
        $this->assertSame('SimpleTrait', $this->class->getProperties()['property2']->getDeclaringClass()->getShortName());
        $this->assertSame('SimpleTrait', $this->class->getProperties()['property3']->getDeclaringClass()->getShortName());
        $this->assertSame('TraitA', $this->class->getProperties()['staticPropertyTraitA']->getDeclaringClass()->getShortName());
        $this->assertSame('TraitA', $this->class->getProperties()['property1TraitA']->getDeclaringClass()->getShortName());
        $this->assertSame('TraitA', $this->class->getProperties()['property2TraitA']->getDeclaringClass()->getShortName());
        $this->assertSame('TraitA', $this->class->getProperties()['property3TraitA']->getDeclaringClass()->getShortName());
        $this->assertSame('TraitB', $this->class->getProperties()['staticPropertyTraitB']->getDeclaringClass()->getShortName());
        $this->assertSame('ClassComplete', $this->class->getProperties()['property1TraitB']->getDeclaringClass()->getShortName());
    }

    public function testSelfGetProperties()
    {
        $this->assertCount(2, $this->class->getSelfProperties());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getSelfProperties());
        $this->assertArrayHasKey('publicStaticPropComplete', $this->class->getSelfProperties());
        $this->assertArrayHasKey('property1TraitB', $this->class->getSelfProperties());
    }

    public function testGetStaticProperties()
    {
        $this->assertCount(5, $this->class->getStaticProperties());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getStaticProperties());
        $this->assertArrayHasKey('publicStaticPropComplete', $this->class->getStaticProperties());
        $this->assertArrayHasKey('property1TraitB', $this->class->getStaticProperties());
        $this->assertArrayHasKey('publicStaticProp', $this->class->getStaticProperties());
        $this->assertArrayHasKey('protectedStaticProp', $this->class->getStaticProperties());
        $this->assertArrayHasKey('privateStaticProp', $this->class->getStaticProperties());
    }

    public function testGetProperty()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperty('publicStaticProp'));
        $this->assertSame('publicStaticProp', $this->class->getProperty('publicStaticProp')->getName());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperty('property2'));
        $this->assertSame('property2', $this->class->getProperty('property2')->getName());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperty('staticPropertyTraitB'));
        $this->assertSame('staticPropertyTraitB', $this->class->getProperty('staticPropertyTraitB')->getName());
    }

    public function testGetPropertyException()
    {
        $this->setExpectedException('ReflectionException', 'Property propertyUnknown does not exist');

        $this->class->getProperty('propertyUnknown');
    }

    public function testGetPublicProperties()
    {
        $this->assertCount(7, $this->class->getProperties(Reflection::IS_PUBLIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PUBLIC));
        $this->assertArrayNotHasKey('property2TraitA', $this->class->getProperties(Reflection::IS_PUBLIC));
        $this->assertArrayNotHasKey('property3', $this->class->getProperties(Reflection::IS_PUBLIC));
    }

    public function testGetProtectedProperties()
    {
        $this->assertCount(3, $this->class->getProperties(Reflection::IS_PROTECTED));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PROTECTED));
        $this->assertArrayNotHasKey('publicStaticPropComplete', $this->class->getProperties(Reflection::IS_PROTECTED));
        $this->assertArrayNotHasKey('publicStaticProp', $this->class->getProperties(Reflection::IS_PROTECTED));
        $this->assertArrayNotHasKey('privateStaticProp', $this->class->getProperties(Reflection::IS_PROTECTED));
    }

    public function testGetPrivateProperties()
    {
        $this->assertCount(3, $this->class->getProperties(Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PRIVATE));
        $this->assertArrayNotHasKey('property1', $this->class->getProperties(Reflection::IS_PRIVATE));
        $this->assertArrayNotHasKey('property2', $this->class->getProperties(Reflection::IS_PRIVATE));
    }

    public function testGetProtectedAndPrivateProperties()
    {
        $this->assertCount(6, $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayNotHasKey('property1', $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayNotHasKey('publicStaticPropComplete', $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayNotHasKey('property1TraitB', $this->class->getProperties(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
    }

    public function testGeStaticProperties()
    {
        $this->assertCount(5, $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionProperty', $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertArrayNotHasKey('property1TraitA', $this->class->getProperties(Reflection::IS_STATIC));
    }

    public function testHasProperty()
    {
        $this->assertSame(true, $this->class->hasProperty('publicStaticPropComplete'));
        $this->assertSame(true, $this->class->hasProperty('publicStaticProp'));
        $this->assertSame(true, $this->class->hasProperty('protectedStaticProp'));
        $this->assertSame(true, $this->class->hasProperty('privateStaticProp'));
        $this->assertSame(true, $this->class->hasProperty('property1'));
        $this->assertSame(true, $this->class->hasProperty('property2'));
        $this->assertSame(true, $this->class->hasProperty('property3'));
        $this->assertSame(true, $this->class->hasProperty('staticPropertyTraitA'));
        $this->assertSame(true, $this->class->hasProperty('property1TraitA'));
        $this->assertSame(true, $this->class->hasProperty('property2TraitA'));
        $this->assertSame(true, $this->class->hasProperty('property3TraitA'));
        $this->assertSame(true, $this->class->hasProperty('staticPropertyTraitB'));
        $this->assertSame(true, $this->class->hasProperty('property1TraitB'));
        $this->assertSame(false, $this->class->hasProperty('$property1'));
        $this->assertSame(false, $this->class->hasProperty('property4'));
        $this->assertSame(false, $this->class->hasProperty('COMMON'));
        $this->assertSame(false, $this->class->hasProperty('FROM_CLASS'));
        $this->assertSame(false, $this->class->hasProperty('AbstractStaticFinalMethods'));
        $this->assertSame(false, $this->class->hasProperty('InterfaceRenamed'));
        $this->assertSame(false, $this->class->hasProperty('InterfaceA'));
    }

    public function testGetDefaultProperties()
    {
        $this->assertCount(13, $this->class->getDefaultProperties());
        $this->assertSame(true, $this->class->getDefaultProperties()['publicStaticPropComplete']);
        $this->assertSame('override !', $this->class->getDefaultProperties()['property1TraitB']);
        $this->assertSame([], $this->class->getDefaultProperties()['staticPropertyTraitA']);
        $this->assertSame(1, $this->class->getDefaultProperties()['property1TraitA']);
        $this->assertSame(true, $this->class->getDefaultProperties()['property2TraitA']);
        $this->assertSame('a string', $this->class->getDefaultProperties()['property3TraitA']);
    }

    public function testGetStaticPropertyValueDefault()
    {
        $this->assertSame('DefaultValue', $this->class->getStaticPropertyValue('property3TraitA', 'DefaultValue'));
        $this->assertSame('DefaultValue', $this->class->getStaticPropertyValue('property12', 'DefaultValue'));
        $this->assertSame(true, $this->class->getStaticPropertyValue('publicStaticPropComplete', 'DefaultValue'));
    }

    public function testGetStaticPropertyValueExceptionNotStatic()
    {
        $this->setExpectedException('ReflectionException', 'Class Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\ClassComplete does not have a property named property1TraitA');

        $this->class->getStaticPropertyValue('property1TraitA');
    }

    public function testGetStaticPropertyValueExceptionDoesNotExist()
    {
        $this->setExpectedException('ReflectionException', 'Class Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\ClassComplete does not have a property named property4');

        $this->class->getStaticPropertyValue('property4');
    }

    public function testSetStaticPropertyValueExceptionNotStatic()
    {
        $this->setExpectedException('ReflectionException', 'Class Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\ClassComplete does not have a property named property1TraitA');

        $this->class->setStaticPropertyValue('property1TraitA', 'DefaultValue');
    }

    public function testGetMethods()
    {
        $this->assertCount(17, $this->class->getMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods());

        $this->assertArrayHasKey('__construct', $this->class->getMethods());
        $this->assertSame('InterfaceA', $this->class->getMethods()['__construct']->getDeclaringClass()->getShortName());
        $this->assertArrayHasKey('publicMethodInterfaceB', $this->class->getMethods());
        $this->assertSame('InterfaceB', $this->class->getMethods()['publicMethodInterfaceB']->getDeclaringClass()->getShortName());
        $this->assertArrayHasKey('publicMethodInterfaceC', $this->class->getMethods());
        $this->assertSame('InterfaceC', $this->class->getMethods()['publicMethodInterfaceC']->getDeclaringClass()->getShortName());

        $this->assertArrayHasKey('method1', $this->class->getMethods());
        $this->assertSame('SimpleTrait', $this->class->getMethods()['method1']->getDeclaringClass()->getShortName());
        $this->assertArrayHasKey('commonTraits', $this->class->getMethods());
        $this->assertSame('TraitA', $this->class->getMethods()['commonTraits']->getDeclaringClass()->getShortName());
        $this->assertArrayHasKey('privateMethodTraitA', $this->class->getMethods());
        $this->assertSame('TraitA', $this->class->getMethods()['privateMethodTraitA']->getDeclaringClass()->getShortName());
        $this->assertArrayHasKey('commonFromTraitB', $this->class->getMethods());
        $this->assertSame('TraitB', $this->class->getMethods()['commonFromTraitB']->getDeclaringClass()->getShortName());

        $this->assertArrayHasKey('abstractProtectedMethod', $this->class->getMethods());
        $this->assertSame('AbstractStaticFinalMethods', $this->class->getMethods()['abstractProtectedMethod']->getDeclaringClass()->getShortName());

        $this->assertArrayHasKey('common', $this->class->getMethods());
        $this->assertSame('ClassComplete', $this->class->getMethods()['common']->getDeclaringClass()->getShortName());
        $this->assertArrayHasKey('publicMethodInterfaceA', $this->class->getMethods());
        $this->assertSame('ClassComplete', $this->class->getMethods()['publicMethodInterfaceA']->getDeclaringClass()->getShortName());
    }

    public function testGetPublicMethods()
    {
        $this->assertCount(13, $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('common', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('publicMethodInterfaceA', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('publicMethodInterfaceB', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('publicMethodInterfaceC', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('finalPublicMethod', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('publicMethodTraitB', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayHasKey('commonTraits', $this->class->getMethods(Reflection::IS_PUBLIC));
        $this->assertArrayNotHasKey('abstractProtectedMethod', $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertArrayNotHasKey('method2', $this->class->getProperties(Reflection::IS_STATIC));
        $this->assertArrayNotHasKey('method3', $this->class->getProperties(Reflection::IS_STATIC));
    }

    public function testGetProtectedMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_PROTECTED));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PROTECTED));
        $this->assertArrayHasKey('abstractProtectedMethod', $this->class->getMethods(Reflection::IS_PROTECTED));
        $this->assertArrayHasKey('method2', $this->class->getMethods(Reflection::IS_PROTECTED));
    }

    public function testGetPrivateMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('method3', $this->class->getMethods(Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('privateMethodTraitA', $this->class->getMethods(Reflection::IS_PRIVATE));
    }

    public function testGetProtectedAndPrivateMethods()
    {
        $this->assertCount(4, $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('method2', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('method3', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('abstractProtectedMethod', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
        $this->assertArrayHasKey('privateMethodTraitA', $this->class->getMethods(Reflection::IS_PROTECTED | Reflection::IS_PRIVATE));
    }

    public function testGeFinalMethods()
    {
        $this->assertCount(1, $this->class->getMethods(Reflection::IS_FINAL));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_FINAL));
        $this->assertArrayHasKey('finalPublicMethod', $this->class->getMethods(Reflection::IS_FINAL));
    }

    public function testGeAbstractMethods()
    {
        $this->assertCount(4, $this->class->getMethods(Reflection::IS_ABSTRACT));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('publicMethodInterfaceB', $this->class->getMethods(Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('publicMethodInterfaceC', $this->class->getMethods(Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('abstractProtectedMethod', $this->class->getMethods(Reflection::IS_ABSTRACT));
        $this->assertArrayHasKey('__construct', $this->class->getMethods(Reflection::IS_ABSTRACT));
    }

    public function testGeStaticMethods()
    {
        $this->assertCount(2, $this->class->getMethods(Reflection::IS_STATIC));
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getMethods(Reflection::IS_STATIC));
        $this->assertArrayHasKey('publicStaticMethod', $this->class->getMethods(Reflection::IS_STATIC));
        $this->assertArrayHasKey('publicStaticMethodTraitA', $this->class->getMethods(Reflection::IS_STATIC));
    }

    public function testGetSelfMethods()
    {
        $this->assertCount(2, $this->class->getSelfMethods());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionMethod', $this->class->getSelfMethods());
        $this->assertArrayHasKey('common', $this->class->getSelfMethods());
        $this->assertArrayHasKey('publicMethodInterfaceA', $this->class->getSelfMethods());
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

    public function testImplementsInterface()
    {
        $this->assertSame(true, $this->class->implementsInterface('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\InterfaceA'));
        $this->assertSame(true, $this->class->implementsInterface('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\InterfaceB'));
        $this->assertSame(true, $this->class->implementsInterface('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\InterfaceC'));
        $this->assertSame(false, $this->class->implementsInterface('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\InterfaceRenamed'));
        $this->assertSame(false, $this->class->implementsInterface('InterfaceRenamed'));
        $this->assertSame(false, $this->class->implementsInterface('Iterator'));
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
