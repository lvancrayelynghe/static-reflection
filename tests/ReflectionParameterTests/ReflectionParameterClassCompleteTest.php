<?php

namespace Benoth\StaticReflection\Tests\ReflectionMethodTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionParameterClassCompleteTest extends AbstractTestCase
{
    protected $class;
    protected $methodMethod1;
    protected $methodMethod2;
    protected $methodMethod3;
    protected $methodPublicMethodInterfaceA;
    protected $methodPublicMethodInterfaceC;
    protected $paramVar1method1;
    protected $paramVar1method2;
    protected $paramVar1method3;
    protected $paramVar1publicMethodInterfaceA;
    protected $paramVar1publicMethodInterfaceC;
    protected $paramVar2publicMethodInterfaceC;
    protected $paramVar3publicMethodInterfaceC;

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
        $this->class                           = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\ClassComplete');
        $this->methodMethod1                   = $this->class->getMethod('method1');
        $this->methodMethod2                   = $this->class->getMethod('method2');
        $this->methodMethod3                   = $this->class->getMethod('method3');
        $this->methodPublicMethodInterfaceA    = $this->class->getMethod('publicMethodInterfaceA');
        $this->methodPublicMethodInterfaceC    = $this->class->getMethod('publicMethodInterfaceC');
        $this->paramVar1method1                = $this->methodMethod1->getParameter('var1');
        $this->paramVar1method2                = $this->methodMethod2->getParameter('var1');
        $this->paramVar1method3                = $this->methodMethod3->getParameter('var1');
        $this->paramVar1publicMethodInterfaceA = $this->methodPublicMethodInterfaceA->getParameter('var1');
        $this->paramVar1publicMethodInterfaceC = $this->methodPublicMethodInterfaceC->getParameter('var1');
        $this->paramVar2publicMethodInterfaceC = $this->methodPublicMethodInterfaceC->getParameter('var2');
        $this->paramVar3publicMethodInterfaceC = $this->methodPublicMethodInterfaceC->getParameter('var3');
    }

    public function testGetDeclaringFunction()
    {
        $this->assertSame($this->methodMethod1, $this->paramVar1method1->getDeclaringFunction());
        $this->assertSame($this->methodMethod2, $this->paramVar1method2->getDeclaringFunction());
        $this->assertSame($this->methodMethod3, $this->paramVar1method3->getDeclaringFunction());
        $this->assertSame($this->methodPublicMethodInterfaceA, $this->paramVar1publicMethodInterfaceA->getDeclaringFunction());
        $this->assertSame($this->methodPublicMethodInterfaceC, $this->paramVar1publicMethodInterfaceC->getDeclaringFunction());
        $this->assertSame($this->methodPublicMethodInterfaceC, $this->paramVar2publicMethodInterfaceC->getDeclaringFunction());
        $this->assertSame($this->methodPublicMethodInterfaceC, $this->paramVar3publicMethodInterfaceC->getDeclaringFunction());
    }

    public function testGetDeclaringClass()
    {
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->paramVar1method1->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->paramVar1method2->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionTrait', $this->paramVar1method3->getDeclaringClass());
        $this->assertSame($this->class, $this->paramVar1publicMethodInterfaceA->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->paramVar1publicMethodInterfaceC->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->paramVar2publicMethodInterfaceC->getDeclaringClass());
        $this->assertInstanceOf('Benoth\StaticReflection\Reflection\ReflectionInterface', $this->paramVar3publicMethodInterfaceC->getDeclaringClass());
    }

    public function testGetFileName()
    {
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php', $this->paramVar1method1->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php', $this->paramVar1method2->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Traits/SimpleTrait.php', $this->paramVar1method3->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/ClassComplete.php', $this->paramVar1publicMethodInterfaceA->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Interfaces/InterfaceC.php', $this->paramVar1publicMethodInterfaceC->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Interfaces/InterfaceC.php', $this->paramVar2publicMethodInterfaceC->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Interfaces/InterfaceC.php', $this->paramVar3publicMethodInterfaceC->getFileName());
    }

    public function testIsByRef()
    {
        $this->assertSame(true, $this->paramVar1method1->isByRef());
        $this->assertSame(false, $this->paramVar1method2->isByRef());
        $this->assertSame(false, $this->paramVar1method3->isByRef());
        $this->assertSame(false, $this->paramVar1publicMethodInterfaceA->isByRef());
        $this->assertSame(true, $this->paramVar1publicMethodInterfaceC->isByRef());
        $this->assertSame(false, $this->paramVar2publicMethodInterfaceC->isByRef());
        $this->assertSame(false, $this->paramVar3publicMethodInterfaceC->isByRef());
    }

    public function testIsRequired()
    {
        $this->assertSame(true, $this->paramVar1method1->isRequired());
        $this->assertSame(false, $this->paramVar1method2->isRequired());
        $this->assertSame(false, $this->paramVar1method3->isRequired());
        $this->assertSame(true, $this->paramVar1publicMethodInterfaceA->isRequired());
        $this->assertSame(true, $this->paramVar1publicMethodInterfaceC->isRequired());
        $this->assertSame(false, $this->paramVar2publicMethodInterfaceC->isRequired());
        $this->assertSame(false, $this->paramVar3publicMethodInterfaceC->isRequired());
    }

    public function testGetType()
    {
        $this->assertSame('', $this->paramVar1method1->getType());
        $this->assertSame('', $this->paramVar1method2->getType());
        $this->assertSame('array', $this->paramVar1method3->getType());
        $this->assertSame('', $this->paramVar1publicMethodInterfaceA->getType());
        $this->assertSame('', $this->paramVar1publicMethodInterfaceC->getType());
        $this->assertSame('', $this->paramVar2publicMethodInterfaceC->getType());
        $this->assertSame('DateTime', $this->paramVar3publicMethodInterfaceC->getType());
    }

    public function testGetDefault()
    {
        $this->assertSame(['null', null], $this->paramVar1method1->getDefault());
        $this->assertSame(['null', null], $this->paramVar1method2->getDefault());
        $this->assertSame(['array', array()], $this->paramVar1method3->getDefault());
        $this->assertSame(['null', null], $this->paramVar1publicMethodInterfaceA->getDefault());
        $this->assertSame(['null', null], $this->paramVar1publicMethodInterfaceC->getDefault());
        $this->assertSame(['boolean', false], $this->paramVar2publicMethodInterfaceC->getDefault());
        $this->assertSame(['boolean', true], $this->paramVar3publicMethodInterfaceC->getDefault());
    }

    public function testGetDefaultType()
    {
        $this->assertSame('null', $this->paramVar1method1->getDefaultType());
        $this->assertSame('null', $this->paramVar1method2->getDefaultType());
        $this->assertSame('array', $this->paramVar1method3->getDefaultType());
        $this->assertSame('null', $this->paramVar1publicMethodInterfaceA->getDefaultType());
        $this->assertSame('null', $this->paramVar1publicMethodInterfaceC->getDefaultType());
        $this->assertSame('boolean', $this->paramVar2publicMethodInterfaceC->getDefaultType());
        $this->assertSame('boolean', $this->paramVar3publicMethodInterfaceC->getDefaultType());
    }

    public function testGetDefaultValue()
    {
        $this->assertSame(null, $this->paramVar1method2->getDefaultValue());
        $this->assertSame(array(), $this->paramVar1method3->getDefaultValue());
        $this->assertSame(false, $this->paramVar2publicMethodInterfaceC->getDefaultValue());
        $this->assertSame(true, $this->paramVar3publicMethodInterfaceC->getDefaultValue());
    }

    public function testGetDefaultValueExceptionCase1()
    {
        $this->setExpectedException('ReflectionException', 'Parameter var1 is required and does not have a default value');

        $this->paramVar1method1->getDefaultValue();
    }

    public function testGetDefaultValueExceptionCase2()
    {
        $this->setExpectedException('ReflectionException', 'Parameter var1 is required and does not have a default value');

        $this->paramVar1publicMethodInterfaceA->getDefaultValue();
    }

    public function testGetDefaultValueExceptionCase3()
    {
        $this->setExpectedException('ReflectionException', 'Parameter var1 is required and does not have a default value');

        $this->paramVar1publicMethodInterfaceC->getDefaultValue();
    }
}
