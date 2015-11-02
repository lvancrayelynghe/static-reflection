<?php

namespace Benoth\StaticReflection\tests;

use Benoth\StaticReflection\Parser\ParsingContext;
use Benoth\StaticReflection\Parser\ReflectorNodeVisitor;
use Benoth\StaticReflection\ReflectionsIndex;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;

abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    public $index;
    public $context;
    public $fixturesPath;

    public function setUp()
    {
        $this->fixturesPath = __DIR__.'/fixtures';

        $phpParserFactory = new ParserFactory();
        $phpParser        = $phpParserFactory->create(ParserFactory::PREFER_PHP7);

        $traverser = new NodeTraverser();

        $this->index   = new ReflectionsIndex();
        $this->context = new ParsingContext($phpParser, $traverser, $this->index);

        $traverser->addVisitor(new NameResolver());
        $traverser->addVisitor(new ReflectorNodeVisitor($this->context));
    }
}
