<?php

namespace Benoth\StaticReflection\tests\ParsingContextTests;

use Benoth\StaticReflection\Tests\AbstractTestCase;

class ParsingContextTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->context->parseFile($this->fixturesPath.'/WithNamespace/Classes/SimpleClass.php');
    }

    public function testParseFile()
    {
        $this->assertSame(null, $this->context->getFilePath());
    }

    public function testGetNamespace()
    {
        $this->assertSame(null, $this->context->getNamespace());
    }

    public function testLeaveReflection()
    {
        $this->assertSame(null, $this->context->leaveReflection());
    }

    public function testGetReflection()
    {
        $this->assertSame(null, $this->context->getReflection());
    }

    public function testGetFunctionLike()
    {
        $this->assertSame(null, $this->context->getFunctionLike());
    }

    public function testLeaveFunctionLike()
    {
        $this->assertSame(null, $this->context->leaveFunctionLike());
    }

    public function testAddErrors()
    {
        $this->assertSame(null, $this->context->addErrors('name', 1, ['error1', 'error2']));
        $this->assertCount(2, $this->context->getErrors());
        $this->assertSame(null, $this->context->addErrors('name2', 2, []));
        $this->assertCount(2, $this->context->getErrors());
    }

    public function testAddError()
    {
        $this->assertSame(null, $this->context->addError('name', 1, 'error'));
        $this->assertCount(1, $this->context->getErrors());
        $this->assertSame(null, $this->context->addError('name2', 2, 'error2'));
        $this->assertCount(2, $this->context->getErrors());
    }

    public function testGetErrors()
    {
        $this->assertSame([], $this->context->getErrors());
    }
}
