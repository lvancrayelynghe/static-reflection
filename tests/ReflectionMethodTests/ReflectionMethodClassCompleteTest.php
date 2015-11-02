<?php

namespace Benoth\StaticReflection\tests\ReflectionMethodTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionMethodClassCompleteTest extends AbstractTestCase
{
    protected $class;
    protected $methodConstruct;
    protected $methodMethod1;
    protected $methodMethod2;
    protected $methodMethod3;
    protected $methodCommon;
    protected $methodPublicMethodInterfaceA;
    protected $methodPublicMethodInterfaceB;
    protected $methodPublicMethodInterfaceC;
    protected $methodCommonTraits;
    protected $methodCommonFromTraitB;
    protected $methodFinalPublicMethod;
    protected $methodPublicMethodTraitA;
    protected $methodPublicMethodTraitB;
    protected $methodPublicStaticMethod;
    protected $methodPrivateMethodTraitA;
    protected $methodAbstractProtectedMethod;
    protected $methodPublicStaticMethodTraitA;

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
        $this->class                          = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\ClassComplete');
        $this->methodConstruct                = $this->class->getMethod('__construct');
        $this->methodMethod1                  = $this->class->getMethod('method1');
        $this->methodMethod2                  = $this->class->getMethod('method2');
        $this->methodMethod3                  = $this->class->getMethod('method3');
        $this->methodCommon                   = $this->class->getMethod('common');
        $this->methodPublicMethodInterfaceA   = $this->class->getMethod('publicMethodInterfaceA');
        $this->methodPublicMethodInterfaceB   = $this->class->getMethod('publicMethodInterfaceB');
        $this->methodPublicMethodInterfaceC   = $this->class->getMethod('publicMethodInterfaceC');
        $this->methodCommonTraits             = $this->class->getMethod('commonTraits');
        $this->methodCommonFromTraitB         = $this->class->getMethod('commonFromTraitB');
        $this->methodFinalPublicMethod        = $this->class->getMethod('finalPublicMethod');
        $this->methodPublicMethodTraitA       = $this->class->getMethod('publicMethodTraitA');
        $this->methodPublicMethodTraitB       = $this->class->getMethod('publicMethodTraitB');
        $this->methodPublicStaticMethod       = $this->class->getMethod('publicStaticMethod');
        $this->methodPrivateMethodTraitA      = $this->class->getMethod('privateMethodTraitA');
        $this->methodAbstractProtectedMethod  = $this->class->getMethod('abstractProtectedMethod');
        $this->methodPublicStaticMethodTraitA = $this->class->getMethod('publicStaticMethodTraitA');
    }

    public function testGetVisibilityPublic()
    {
        $this->assertSame(256, $this->methodConstruct->getVisibility());
        $this->assertSame(true, $this->methodConstruct->isPublic());
        $this->assertSame(256, $this->methodMethod1->getVisibility());
        $this->assertSame(true, $this->methodMethod1->isPublic());
        $this->assertSame(false, $this->methodMethod2->isPublic());
        $this->assertSame(false, $this->methodMethod3->isPublic());
    }

    public function testGetVisibilityProtected()
    {
        $this->assertSame(512, $this->methodMethod2->getVisibility());
        $this->assertSame(false, $this->methodMethod1->isProtected());
        $this->assertSame(true, $this->methodMethod2->isProtected());
        $this->assertSame(false, $this->methodMethod3->isProtected());
        $this->assertSame(false, $this->methodConstruct->isProtected());
        $this->assertSame(false, $this->methodPublicMethodInterfaceB->isProtected());
    }

    public function testGetVisibilityPrivate()
    {
        $this->assertSame(1024, $this->methodMethod3->getVisibility());
        $this->assertSame(false, $this->methodMethod1->isPrivate());
        $this->assertSame(false, $this->methodMethod2->isPrivate());
        $this->assertSame(true, $this->methodMethod3->isPrivate());
        $this->assertSame(false, $this->methodConstruct->isPrivate());
        $this->assertSame(false, $this->methodPublicMethodInterfaceB->isPrivate());
    }

    public function testIsStatic()
    {
        $this->assertSame(false, $this->methodConstruct->isStatic());
        $this->assertSame(false, $this->methodMethod1->isStatic());
        $this->assertSame(false, $this->methodMethod2->isStatic());
        $this->assertSame(true, $this->methodPublicStaticMethod->isStatic());
    }

    public function testIsAbstract()
    {
        $this->assertSame(true, $this->methodConstruct->isAbstract());
        $this->assertSame(false, $this->methodMethod1->isAbstract());
        $this->assertSame(false, $this->methodMethod2->isAbstract());
        $this->assertSame(false, $this->methodMethod3->isAbstract());
        $this->assertSame(true, $this->methodAbstractProtectedMethod->isAbstract());
    }

    public function testIsFinal()
    {
        $this->assertSame(false, $this->methodConstruct->isFinal());
        $this->assertSame(false, $this->methodMethod1->isFinal());
        $this->assertSame(false, $this->methodMethod2->isFinal());
        $this->assertSame(false, $this->methodMethod3->isFinal());
        $this->assertSame(true, $this->methodFinalPublicMethod->isFinal());
    }

    public function testGetDeclaringClass()
    {
        $this->assertSame($this->class, $this->methodCommon->getDeclaringClass());
        $this->assertSame($this->class, $this->methodPublicMethodInterfaceA->getDeclaringClass());
        $this->assertNotSame($this->class, $this->methodPublicStaticMethodTraitA->getDeclaringClass());
        $this->assertNotSame($this->class, $this->methodPublicMethodInterfaceC->getDeclaringClass());
        $this->assertNotSame($this->class, $this->methodPublicMethodTraitA->getDeclaringClass());
        $this->assertNotSame($this->class, $this->methodPrivateMethodTraitA->getDeclaringClass());
        $this->assertNotSame($this->class, $this->methodPublicMethodInterfaceB->getDeclaringClass());

        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->methodPublicStaticMethodTraitA->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->methodPublicMethodTraitA->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->methodPrivateMethodTraitA->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->methodPublicMethodInterfaceB->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->methodPublicMethodInterfaceC->getDeclaringClass());
    }

    public function testGetFileName()
    {
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/ClassComplete.php', $this->methodCommon->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/ClassComplete.php', $this->methodPublicMethodInterfaceA->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/TraitA.php', $this->methodPrivateMethodTraitA->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Interfaces/InterfaceC.php', $this->methodPublicMethodInterfaceC->getFileName());
    }

    public function testGetParameters()
    {
        $this->assertCount(0, $this->methodConstruct->getParameters());
        $this->assertCount(1, $this->methodMethod1->getParameters());
        $this->assertCount(1, $this->methodMethod2->getParameters());
        $this->assertCount(1, $this->methodMethod3->getParameters());
        $this->assertCount(3, $this->methodPublicMethodInterfaceC->getParameters());

        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodConstruct->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodMethod1->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodMethod2->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodMethod3->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodCommon->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPublicMethodInterfaceA->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPublicMethodInterfaceB->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPublicMethodInterfaceC->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodCommonTraits->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodCommonFromTraitB->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodFinalPublicMethod->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPublicMethodTraitA->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPublicMethodTraitB->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPublicStaticMethod->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPrivateMethodTraitA->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodAbstractProtectedMethod->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodPublicStaticMethodTraitA->getParameters());
    }

    public function testReturnsByRef()
    {
        $this->assertSame(false, $this->methodConstruct->returnsByRef());
        $this->assertSame(false, $this->methodMethod1->returnsByRef());
        $this->assertSame(false, $this->methodMethod2->returnsByRef());
        $this->assertSame(false, $this->methodMethod3->returnsByRef());
        $this->assertSame(false, $this->methodCommon->returnsByRef());
        $this->assertSame(false, $this->methodPublicMethodInterfaceA->returnsByRef());
        $this->assertSame(false, $this->methodPublicMethodInterfaceB->returnsByRef());
        $this->assertSame(false, $this->methodPublicMethodInterfaceC->returnsByRef());
        $this->assertSame(false, $this->methodCommonTraits->returnsByRef());
        $this->assertSame(false, $this->methodCommonFromTraitB->returnsByRef());
        $this->assertSame(false, $this->methodFinalPublicMethod->returnsByRef());
        $this->assertSame(false, $this->methodPublicMethodTraitA->returnsByRef());
        $this->assertSame(false, $this->methodPublicMethodTraitB->returnsByRef());
        $this->assertSame(false, $this->methodPublicStaticMethod->returnsByRef());
        $this->assertSame(false, $this->methodPrivateMethodTraitA->returnsByRef());
        $this->assertSame(false, $this->methodAbstractProtectedMethod->returnsByRef());
        $this->assertSame(false, $this->methodPublicStaticMethodTraitA->returnsByRef());
    }
}
