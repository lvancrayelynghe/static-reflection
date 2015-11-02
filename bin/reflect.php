#!/usr/bin/env php
<?php

foreach ([__DIR__.'/../../../autoload.php', __DIR__.'/../vendor/autoload.php'] as $file) {
    if (file_exists($file)) {
        require $file;
        break;
    }
}
ini_set('xdebug.max_nesting_level', 3000);

use Benoth\StaticReflection\Parser\DebugNodeVisitor;
use Benoth\StaticReflection\Parser\ParsingContext;
use Benoth\StaticReflection\Parser\ReflectorNodeVisitor;
use Benoth\StaticReflection\ReflectionsIndex;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;

$fixturesPath = __DIR__.'/../tests/Fixtures';

$phpParserFactory = new ParserFactory();
$phpParser        = $phpParserFactory->create(ParserFactory::PREFER_PHP7);

$traverser = new NodeTraverser();

$index   = new ReflectionsIndex();
$context = new ParsingContext($phpParser, $traverser, $index);

$traverser->addVisitor(new NameResolver());
// $traverser->addVisitor(new DebugNodeVisitor());
$traverser->addVisitor(new ReflectorNodeVisitor($context));

$argc = $argc - 1;
array_shift($argv);

if ($argc <= 0) {
    exit('You need to provide one or more pathes');
}

foreach ($argv as $arg) {
    if (!file_exists($arg)) {
        exit('Not a file or directory: '.$arg);
    } elseif (is_file($arg)) {
        echo 'Parsing '.$arg.PHP_EOL;
        $context->parseFile($arg);
    } elseif (is_dir($arg)) {
        $iterator = new RecursiveDirectoryIterator($arg);
        foreach (new RecursiveIteratorIterator($iterator) as $file) {
            if (strtolower(substr($file, strrpos($file, '.') + 1)) == 'php') {
                echo 'Parsing '.$file->getRealPath().PHP_EOL;
                $context->parseFile($file->getRealPath());
            }
        }
    }
}

echo PHP_EOL;

$classes    = $index->getClasses();
$interfaces = $index->getInterfaces();
$traits     = $index->getTraits();
$functions  = $index->getFunctions();
foreach (['classes', 'interfaces', 'traits', 'functions'] as $type) {
    if (empty($$type)) {
        continue;
    }
    echo ucfirst($type).' :'.PHP_EOL;
    foreach ($$type as $reflection) {
        echo '  - '.$reflection->getName().PHP_EOL;
        if ($reflection instanceof ReflectionClassLike) {
            foreach ($reflection->getMethods() as $methodName => $method) {
                echo '      * '.$methodName.'()'.PHP_EOL;
            }
        }
    }
    echo PHP_EOL;
}
