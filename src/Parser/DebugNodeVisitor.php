<?php

namespace Benoth\StaticReflection\Parser;

use PhpParser\Node as NodeInterface;
use PhpParser\NodeVisitorAbstract;

/**
 * @codeCoverageIgnore
 */
class DebugNodeVisitor extends NodeVisitorAbstract
{
    protected $level = 0;

    public function enterNode(NodeInterface $node)
    {
        $this->debug(str_repeat('  ', ++$this->level).$node->getType().(property_exists($node, 'name') ? ' '.(method_exists($node->name, 'toString') ? $node->name->toString() : $node->name) : '').(method_exists($node, 'getLine') ? ' L:'.$node->getLine() : '').PHP_EOL);
    }

    public function leaveNode(NodeInterface $node)
    {
        --$this->level;
    }

    public function beforeTraverse(array $nodes)
    {
        $this->level = 0;
        $this->debug('BeforeTraverse'.PHP_EOL);
    }

    public function afterTraverse(array $nodes)
    {
        $this->level = 0;
        $this->debug('AfterTraverse'.PHP_EOL);
    }

    /**
     * @param string $text
     */
    protected function debug($text)
    {
        echo $text;
    }
}
