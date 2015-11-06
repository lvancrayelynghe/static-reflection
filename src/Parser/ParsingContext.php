<?php

namespace Benoth\StaticReflection\Parser;

use Benoth\StaticReflection\Reflection\Reflection;
use Benoth\StaticReflection\Reflection\ReflectionFunctionAbstract;
use Benoth\StaticReflection\ReflectionsIndex;
use PhpParser\Error as PhpParserException;
use PhpParser\NodeTraverserInterface;
use PhpParser\Parser as ParserInterface;

class ParsingContext
{
    protected $parser;
    protected $traverser;
    protected $index;

    protected $file;
    protected $errors = [];

    protected $namespace;
    protected $aliases = [];
    protected $reflection;
    protected $functionLike;

    public function __construct(ParserInterface $parser, NodeTraverserInterface $traverser, ReflectionsIndex $index)
    {
        ini_set('xdebug.max_nesting_level', 10000);

        $this->parser    = $parser;
        $this->traverser = $traverser;
        $this->index     = $index;
    }

    public function parseFile($file)
    {
        $this->file        = $file;
        $this->errors      = [];

        try {
            $this->traverser->traverse($this->parser->parse($this->getFileContent()));
        } catch (PhpParserException $e) {
            $this->addError($this->getFilePath(), 0, $e->getMessage());
        }

        $this->file = null;

        return $this;
    }

    public function getFilePath()
    {
        return $this->file;
    }

    public function getFileContent()
    {
        if (!file_exists($this->getFilePath())) {
            throw new PhpParserException('File '.$this->getFilePath().' does not exist');
        }

        return file_get_contents($this->getFilePath());
    }

    /**
     * @param string $name
     */
    public function addAlias($alias, $name)
    {
        $this->aliases[$alias] = $name;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param string $namespace
     */
    public function enterNamespace($namespace)
    {
        $this->namespace = $namespace;
        $this->aliases   = array();

        return $this;
    }

    public function leaveNamespace()
    {
        $this->namespace = null;
        $this->aliases   = array();

        return $this;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function enterReflection(Reflection $reflection)
    {
        $this->reflection = $reflection;
    }

    public function leaveReflection()
    {
        if ($this->reflection === null) {
            return;
        }

        $this->index->addReflection($this->reflection);

        $this->reflection = null;
    }

    public function enterFunctionLike(ReflectionFunctionAbstract $reflection)
    {
        $this->functionLike = $reflection;
    }

    public function getFunctionLike()
    {
        return $this->functionLike;
    }

    public function leaveFunctionLike()
    {
        $this->functionLike = null;
    }

    public function getReflection()
    {
        return $this->reflection;
    }

    public function addErrors($name, $line, array $errors)
    {
        foreach ($errors as $error) {
            $this->addError($name, $line, $error);
        }
    }

    public function addError($name, $line, $error)
    {
        $this->errors[] = sprintf('%s on "%s" in %s:%d', $error, $name, $this->file, $line);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
