<?php

namespace Benoth\StaticReflection\tests\ReflectionMethodTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class ReflectionMethodSimpleClassTest extends AbstractTestCase
{
    protected $class;
    protected $methodConstruct;
    protected $methodMethod1;
    protected $methodMethod2;
    protected $methodMethod3;

    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Classes/SimpleClass.php');
        $this->class           = $this->index->getClass('Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes\SimpleClass');
        $this->methodConstruct = $this->class->getMethod('__construct');
        $this->methodMethod1   = $this->class->getMethod('method1');
        $this->methodMethod2   = $this->class->getMethod('method2');
        $this->methodMethod3   = $this->class->getMethod('method3');
    }

    public function testGetVisibilityPublic()
    {
        $this->assertSame(256, $this->methodConstruct->getVisibility());
        $this->assertSame(256, $this->methodMethod1->getVisibility());
        $this->assertSame(true, $this->methodConstruct->isPublic());
        $this->assertSame(true, $this->methodMethod1->isPublic());
        $this->assertSame(false, $this->methodMethod2->isPublic());
        $this->assertSame(false, $this->methodMethod3->isPublic());
    }

    public function testGetVisibilityProtected()
    {
        $this->assertSame(512, $this->methodMethod2->getVisibility());
        $this->assertSame(false, $this->methodConstruct->isProtected());
        $this->assertSame(false, $this->methodMethod1->isProtected());
        $this->assertSame(true, $this->methodMethod2->isProtected());
        $this->assertSame(false, $this->methodMethod3->isProtected());
    }

    public function testGetVisibilityPrivate()
    {
        $this->assertSame(1024, $this->methodMethod3->getVisibility());
        $this->assertSame(false, $this->methodConstruct->isPrivate());
        $this->assertSame(false, $this->methodMethod1->isPrivate());
        $this->assertSame(false, $this->methodMethod2->isPrivate());
        $this->assertSame(true, $this->methodMethod3->isPrivate());
    }

    public function testIsStatic()
    {
        $this->assertSame(false, $this->methodConstruct->isStatic());
        $this->assertSame(false, $this->methodMethod1->isStatic());
        $this->assertSame(false, $this->methodMethod2->isStatic());
        $this->assertSame(false, $this->methodMethod3->isStatic());
    }

    public function testIsAbstract()
    {
        $this->assertSame(false, $this->methodConstruct->isAbstract());
        $this->assertSame(false, $this->methodMethod1->isAbstract());
        $this->assertSame(false, $this->methodMethod2->isAbstract());
        $this->assertSame(false, $this->methodMethod3->isAbstract());
    }

    public function testIsFinal()
    {
        $this->assertSame(false, $this->methodConstruct->isFinal());
        $this->assertSame(false, $this->methodMethod1->isFinal());
        $this->assertSame(false, $this->methodMethod2->isFinal());
        $this->assertSame(false, $this->methodMethod3->isFinal());
    }

    public function testGetDeclaringClass()
    {
        $this->assertSame($this->class, $this->methodConstruct->getDeclaringClass());
        $this->assertSame($this->class, $this->methodMethod1->getDeclaringClass());
        $this->assertSame($this->class, $this->methodMethod2->getDeclaringClass());
        $this->assertSame($this->class, $this->methodMethod3->getDeclaringClass());
    }

    public function testGetFileName()
    {
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/SimpleClass.php', $this->methodConstruct->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/SimpleClass.php', $this->methodMethod1->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/SimpleClass.php', $this->methodMethod2->getFileName());
        $this->assertSame($this->fixturesPath.'/WithNamespace/Classes/SimpleClass.php', $this->methodMethod3->getFileName());
    }

    public function testGetParameters()
    {
        $this->assertCount(0, $this->methodConstruct->getParameters());
        $this->assertCount(1, $this->methodMethod1->getParameters());
        $this->assertCount(1, $this->methodMethod2->getParameters());
        $this->assertCount(1, $this->methodMethod3->getParameters());

        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodConstruct->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodMethod1->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodMethod2->getParameters());
        $this->assertContainsOnlyInstancesOf('Benoth\StaticReflection\Reflection\ReflectionParameter', $this->methodMethod3->getParameters());
    }

    public function testReturnsByRef()
    {
        $this->assertSame(false, $this->methodConstruct->returnsByRef());
        $this->assertSame(false, $this->methodMethod1->returnsByRef());
        $this->assertSame(false, $this->methodMethod2->returnsByRef());
        $this->assertSame(false, $this->methodMethod3->returnsByRef());
    }

    public function testIsDeprecated()
    {
        $this->assertSame(false, $this->methodConstruct->isDeprecated());
        $this->assertSame(false, $this->methodMethod1->isDeprecated());
        $this->assertSame(false, $this->methodMethod2->isDeprecated());
        $this->assertSame(false, $this->methodMethod3->isDeprecated());
    }

    public function testIsGenerator()
    {
        $this->assertSame(false, $this->methodConstruct->isGenerator());
        $this->assertSame(false, $this->methodMethod1->isGenerator());
        $this->assertSame(false, $this->methodMethod2->isGenerator());
        $this->assertSame(true, $this->methodMethod3->isGenerator());
    }
}
