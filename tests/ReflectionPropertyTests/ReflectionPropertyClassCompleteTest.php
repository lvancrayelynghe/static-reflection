<?php

namespace Benoth\StaticReflection\tests\ReflectionPropertyTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionPropertyClassCompleteTest extends AbstractTestCase
{
    protected $class;
    protected $propPrivateStaticProp;
    protected $propProperty1;
    protected $propProperty1TraitA;
    protected $propProperty1TraitB;
    protected $propProperty2;
    protected $propProperty2TraitA;
    protected $propProperty3;
    protected $propProperty3TraitA;
    protected $propProtectedStaticProp;
    protected $propPublicStaticProp;
    protected $propPublicStaticPropComplete;
    protected $propStaticPropertyTraitA;
    protected $propStaticPropertyTraitB;

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
        $this->class                        = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\ClassComplete');
        $this->propPrivateStaticProp        = $this->class->getProperty('privateStaticProp');
        $this->propProperty1                = $this->class->getProperty('property1');
        $this->propProperty1TraitA          = $this->class->getProperty('property1TraitA');
        $this->propProperty1TraitB          = $this->class->getProperty('property1TraitB');
        $this->propProperty2                = $this->class->getProperty('property2');
        $this->propProperty2TraitA          = $this->class->getProperty('property2TraitA');
        $this->propProperty3                = $this->class->getProperty('property3');
        $this->propProperty3TraitA          = $this->class->getProperty('property3TraitA');
        $this->propProtectedStaticProp      = $this->class->getProperty('protectedStaticProp');
        $this->propPublicStaticProp         = $this->class->getProperty('publicStaticProp');
        $this->propPublicStaticPropComplete = $this->class->getProperty('publicStaticPropComplete');
        $this->propStaticPropertyTraitA     = $this->class->getProperty('staticPropertyTraitA');
        $this->propStaticPropertyTraitB     = $this->class->getProperty('staticPropertyTraitB');
    }

    public function testGetVisibilityPublic()
    {
        $this->assertSame(false, $this->propPrivateStaticProp->isPublic());
        $this->assertSame(true, $this->propProperty1->isPublic());
        $this->assertSame(false, $this->propProperty2->isPublic());
        $this->assertSame(false, $this->propProperty2TraitA->isPublic());
        $this->assertSame(false, $this->propProperty3->isPublic());
        $this->assertSame(false, $this->propProperty3TraitA->isPublic());
        $this->assertSame(false, $this->propProtectedStaticProp->isPublic());
        $this->assertSame(true, $this->propProperty1TraitA->isPublic());
        $this->assertSame(true, $this->propProperty1TraitB->isPublic());
        $this->assertSame(true, $this->propProperty1TraitB->isPublic());
        $this->assertSame(true, $this->propPublicStaticProp->isPublic());
        $this->assertSame(true, $this->propPublicStaticPropComplete->isPublic());
        $this->assertSame(true, $this->propStaticPropertyTraitA->isPublic());
        $this->assertSame(true, $this->propStaticPropertyTraitB->isPublic());
        $this->assertSame(true, $this->propPublicStaticPropComplete->isPublic());
        $this->assertSame(256, $this->propPublicStaticPropComplete->getVisibility());
    }

    public function testGetVisibilityProtected()
    {
        $this->assertSame(false, $this->propPrivateStaticProp->isProtected());
        $this->assertSame(false, $this->propProperty1->isProtected());
        $this->assertSame(false, $this->propProperty1TraitA->isProtected());
        $this->assertSame(false, $this->propProperty1TraitB->isProtected());
        $this->assertSame(false, $this->propProperty3->isProtected());
        $this->assertSame(false, $this->propProperty3TraitA->isProtected());
        $this->assertSame(false, $this->propPublicStaticProp->isProtected());
        $this->assertSame(false, $this->propPublicStaticPropComplete->isProtected());
        $this->assertSame(false, $this->propStaticPropertyTraitA->isProtected());
        $this->assertSame(false, $this->propStaticPropertyTraitB->isProtected());
        $this->assertSame(true, $this->propProperty2->isProtected());
        $this->assertSame(true, $this->propProperty2TraitA->isProtected());
        $this->assertSame(true, $this->propProtectedStaticProp->isProtected());
        $this->assertSame(512, $this->propProtectedStaticProp->getVisibility());
    }

    public function testGetVisibilityPrivate()
    {
        $this->assertSame(false, $this->propProperty1->isPrivate());
        $this->assertSame(false, $this->propProperty1TraitA->isPrivate());
        $this->assertSame(false, $this->propProperty1TraitB->isPrivate());
        $this->assertSame(false, $this->propProperty2->isPrivate());
        $this->assertSame(false, $this->propProperty2TraitA->isPrivate());
        $this->assertSame(false, $this->propProtectedStaticProp->isPrivate());
        $this->assertSame(false, $this->propPublicStaticProp->isPrivate());
        $this->assertSame(false, $this->propPublicStaticPropComplete->isPrivate());
        $this->assertSame(false, $this->propStaticPropertyTraitA->isPrivate());
        $this->assertSame(false, $this->propStaticPropertyTraitB->isPrivate());
        $this->assertSame(true, $this->propPrivateStaticProp->isPrivate());
        $this->assertSame(true, $this->propProperty3->isPrivate());
        $this->assertSame(true, $this->propProperty3TraitA->isPrivate());
        $this->assertSame(1024, $this->propProperty3TraitA->getVisibility());
    }

    public function testIsStatic()
    {
        $this->assertSame(false, $this->propProperty1->isStatic());
        $this->assertSame(false, $this->propProperty1TraitA->isStatic());
        $this->assertSame(false, $this->propProperty2->isStatic());
        $this->assertSame(false, $this->propProperty2TraitA->isStatic());
        $this->assertSame(false, $this->propProperty3->isStatic());
        $this->assertSame(false, $this->propProperty3TraitA->isStatic());
        $this->assertSame(false, $this->propStaticPropertyTraitA->isStatic());
        $this->assertSame(false, $this->propStaticPropertyTraitB->isStatic());
        $this->assertSame(true, $this->propPrivateStaticProp->isStatic());
        $this->assertSame(true, $this->propProperty1TraitB->isStatic());
        $this->assertSame(true, $this->propProtectedStaticProp->isStatic());
        $this->assertSame(true, $this->propPublicStaticProp->isStatic());
        $this->assertSame(true, $this->propPublicStaticPropComplete->isStatic());
    }

    public function testGetDeclaringClass()
    {
        $this->assertSame($this->class, $this->propProperty1TraitB->getDeclaringClass());
        $this->assertSame($this->class, $this->propPublicStaticPropComplete->getDeclaringClass());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractStaticFinalMethods', $this->propPrivateStaticProp->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractStaticFinalMethods', $this->propProtectedStaticProp->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\AbstractStaticFinalMethods', $this->propPublicStaticProp->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\SimpleTrait', $this->propProperty1->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\SimpleTrait', $this->propProperty2->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\SimpleTrait', $this->propProperty3->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitA', $this->propProperty1TraitA->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitA', $this->propProperty2TraitA->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitA', $this->propProperty3TraitA->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitA', $this->propStaticPropertyTraitA->getDeclaringClass()->getName());
        $this->assertSame('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitB', $this->propStaticPropertyTraitB->getDeclaringClass()->getName());
    }

    public function testGetFileName()
    {
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/AbstractStaticFinalMethods.php', $this->propPrivateStaticProp->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/AbstractStaticFinalMethods.php', $this->propProtectedStaticProp->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/AbstractStaticFinalMethods.php', $this->propPublicStaticProp->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/ClassComplete.php', $this->propProperty1TraitB->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/ClassComplete.php', $this->propPublicStaticPropComplete->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php', $this->propProperty1->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php', $this->propProperty2->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php', $this->propProperty3->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/TraitA.php', $this->propProperty1TraitA->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/TraitA.php', $this->propProperty2TraitA->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/TraitA.php', $this->propProperty3TraitA->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/TraitA.php', $this->propStaticPropertyTraitA->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/TraitB.php', $this->propStaticPropertyTraitB->getFileName());
    }

    public function testGetDocComment()
    {
        $this->assertNotSame('', $this->propPublicStaticPropComplete->getDocComment());
        $this->assertNotSame('', $this->propStaticPropertyTraitB->getDocComment());
        $this->assertSame('', $this->propPrivateStaticProp->getDocComment());
        $this->assertSame('', $this->propProperty1->getDocComment());
        $this->assertSame('', $this->propProperty1TraitA->getDocComment());
        $this->assertSame('', $this->propProperty1TraitB->getDocComment());
        $this->assertSame('', $this->propProperty2->getDocComment());
        $this->assertSame('', $this->propProperty2TraitA->getDocComment());
        $this->assertSame('', $this->propProperty3->getDocComment());
        $this->assertSame('', $this->propProperty3TraitA->getDocComment());
        $this->assertSame('', $this->propProtectedStaticProp->getDocComment());
        $this->assertSame('', $this->propPublicStaticProp->getDocComment());
        $this->assertSame('', $this->propStaticPropertyTraitA->getDocComment());
    }

    public function testGetDefault()
    {
        $this->assertSame(['null', null], $this->propPrivateStaticProp->getDefault());
        $this->assertSame(['integer', 1], $this->propProperty1->getDefault());
        $this->assertSame(['integer', 1], $this->propProperty1TraitA->getDefault());
        $this->assertSame(['string', 'override !'], $this->propProperty1TraitB->getDefault());
        $this->assertSame(['integer', 2], $this->propProperty2->getDefault());
        $this->assertSame(['boolean', true], $this->propProperty2TraitA->getDefault());
        $this->assertSame(['null', null], $this->propProperty3->getDefault());
        $this->assertSame(['string', 'a string'], $this->propProperty3TraitA->getDefault());
        $this->assertSame(['array', array()], $this->propProtectedStaticProp->getDefault());
        $this->assertSame(['double', 1.1], $this->propPublicStaticProp->getDefault());
        $this->assertSame(['boolean', true], $this->propPublicStaticPropComplete->getDefault());
        $this->assertSame(['array', array()], $this->propStaticPropertyTraitA->getDefault());
        $this->assertSame(['integer', 1], $this->propStaticPropertyTraitB->getDefault());
    }

    public function testGetDefaultType()
    {
        $this->assertSame('null', $this->propPrivateStaticProp->getDefaultType());
        $this->assertSame('integer', $this->propProperty1->getDefaultType());
        $this->assertSame('integer', $this->propProperty1TraitA->getDefaultType());
        $this->assertSame('string', $this->propProperty1TraitB->getDefaultType());
        $this->assertSame('integer', $this->propProperty2->getDefaultType());
        $this->assertSame('boolean', $this->propProperty2TraitA->getDefaultType());
        $this->assertSame('null', $this->propProperty3->getDefaultType());
        $this->assertSame('string', $this->propProperty3TraitA->getDefaultType());
        $this->assertSame('array', $this->propProtectedStaticProp->getDefaultType());
        $this->assertSame('double', $this->propPublicStaticProp->getDefaultType());
        $this->assertSame('boolean', $this->propPublicStaticPropComplete->getDefaultType());
        $this->assertSame('array', $this->propStaticPropertyTraitA->getDefaultType());
        $this->assertSame('integer', $this->propStaticPropertyTraitB->getDefaultType());
    }

    public function testGetDefaultValue()
    {
        $this->assertSame(null, $this->propPrivateStaticProp->getDefaultValue());
        $this->assertSame(1, $this->propProperty1->getDefaultValue());
        $this->assertSame(1, $this->propProperty1TraitA->getDefaultValue());
        $this->assertSame('override !', $this->propProperty1TraitB->getDefaultValue());
        $this->assertSame(2, $this->propProperty2->getDefaultValue());
        $this->assertSame(true, $this->propProperty2TraitA->getDefaultValue());
        $this->assertSame(null, $this->propProperty3->getDefaultValue());
        $this->assertSame('a string', $this->propProperty3TraitA->getDefaultValue());
        $this->assertSame(array(), $this->propProtectedStaticProp->getDefaultValue());
        $this->assertSame(1.1, $this->propPublicStaticProp->getDefaultValue());
        $this->assertSame(true, $this->propPublicStaticPropComplete->getDefaultValue());
        $this->assertSame(array(), $this->propStaticPropertyTraitA->getDefaultValue());
        $this->assertSame(1, $this->propStaticPropertyTraitB->getDefaultValue());
    }
}
