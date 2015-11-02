<?php

namespace Benoth\StaticReflection\Parser;

use Benoth\StaticReflection\Reflection\ReflectionClass;
use Benoth\StaticReflection\Reflection\ReflectionConstant;
use Benoth\StaticReflection\Reflection\ReflectionFunction;
use Benoth\StaticReflection\Reflection\ReflectionFunctionAbstract;
use Benoth\StaticReflection\Reflection\ReflectionInterface;
use Benoth\StaticReflection\Reflection\ReflectionMethod;
use Benoth\StaticReflection\Reflection\ReflectionParameter;
use Benoth\StaticReflection\Reflection\ReflectionProperty;
use Benoth\StaticReflection\Reflection\ReflectionTrait;
use PhpParser\Node as NodeInterface;
use PhpParser\Node\Stmt as AbstractNode;
use PhpParser\Node\Stmt\Class_ as ClassNode;
use PhpParser\Node\Stmt\ClassConst as ClassConstNode;
use PhpParser\Node\Stmt\ClassMethod as ClassMethodNode;
use PhpParser\Node\Stmt\Function_ as FunctionNode;
use PhpParser\Node\Stmt\Interface_ as InterfaceNode;
use PhpParser\Node\Stmt\Namespace_ as NamespaceNode;
use PhpParser\Node\Stmt\Property as PropertyNode;
use PhpParser\Node\Stmt\Static_ as StaticNode;
use PhpParser\Node\Stmt\Trait_ as TraitNode;
use PhpParser\Node\Stmt\TraitUse as TraitUseNode;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias as TraitUseAliasNode;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence as TraitUsePrecedenceNode;
use PhpParser\Node\Stmt\Use_ as UseNode;
use PhpParser\Node\Expr as AbstractExprNode;
use PhpParser\Node\Expr\Yield_ as YieldNode;
use PhpParser\Node\Expr\YieldFrom as YieldFromNode;
use PhpParser\NodeVisitorAbstract;

class ReflectorNodeVisitor extends NodeVisitorAbstract
{
    protected $context;

    public function __construct(ParsingContext $context)
    {
        $this->context = $context;
    }

    public function enterNode(NodeInterface $node)
    {
        // @todo Handle global constants

        if ($node instanceof NamespaceNode) {
            $this->context->enterNamespace((string) $node->name);
        } elseif ($node instanceof UseNode) {
            $this->addAliases($node);
        } elseif ($node instanceof FunctionNode) {
            $this->addFunction($node);
        } elseif ($node instanceof ClassNode) {
            $this->addClass($node);
        } elseif ($node instanceof InterfaceNode) {
            $this->addInterface($node);
        } elseif ($node instanceof TraitNode) {
            $this->addTrait($node);
        } elseif ($this->context->getReflection() && $node instanceof TraitUseNode) {
            $this->addTraitUse($node);
        } elseif ($this->context->getReflection() && $node instanceof ClassConstNode) {
            $this->addConstant($node);
        } elseif ($this->context->getReflection() && $node instanceof PropertyNode) {
            $this->addProperty($node);
        } elseif ($this->context->getReflection() && $node instanceof ClassMethodNode) {
            $this->addMethod($node);
        } elseif ($this->context->getFunctionLike() && $node instanceof StaticNode) {
            $this->addStaticVariable($node);
        } elseif ($this->context->getFunctionLike() && ($node instanceof YieldNode || $node instanceof YieldFromNode)) {
            $this->addYieldNode($node);
        }
    }

    public function leaveNode(NodeInterface $node)
    {
        if ($node instanceof FunctionNode || $node instanceof ClassMethodNode) {
            $this->context->leaveFunctionLike();
        }

        if ($node instanceof NamespaceNode) {
            $this->context->leaveNamespace();
        } elseif ($node instanceof FunctionNode || $node instanceof ClassNode || $node instanceof InterfaceNode || $node instanceof TraitNode) {
            $this->context->leaveReflection();
        }
    }

    protected function addAliases(UseNode $node)
    {
        foreach ($node->uses as $use) {
            $this->context->addAlias($use->alias, (string) $use->name);
        }
    }

    protected function addClass(ClassNode $node)
    {
        $class = $this->buildClassLikeReflection($node);
        $class->setAbstract((bool) $node->isAbstract());
        $class->setFinal((bool) $node->isFinal());

        if ($node->extends) {
            $class->setParent((string) $node->extends);
        }

        foreach ($node->implements as $interface) {
            $class->addInterface((string) $interface);
        }
    }

    public function addInterface(InterfaceNode $node)
    {
        $interface = $this->buildClassLikeReflection($node);

        foreach ($node->extends as $extend) {
            $interface->addInterface((string) $extend);
        }
    }

    public function addTrait(TraitNode $node)
    {
        $trait = $this->buildClassLikeReflection($node);
    }

    public function addTraitUse(TraitUseNode $node)
    {
        foreach ($node->traits as $trait) {
            $this->context->getReflection()->addTrait((string) $trait);
            foreach ($node->adaptations as $adaptation) {
                if ($adaptation instanceof TraitUseAliasNode) {
                    $this->addTraitUseAlias($adaptation, $trait);
                } else {
                    $this->addTraitUsePrecedence($adaptation);
                }
            }
        }
    }

    public function addTraitUseAlias(TraitUseAliasNode $adaptation, $trait)
    {
        if (is_null($adaptation->trait)) {
            $this->context->getReflection()->addTraitMethodAlias((string) $trait->toString(), (string) $adaptation->method, (string) $adaptation->newName);
        } else {
            $this->context->getReflection()->addTraitMethodAlias((string) $adaptation->trait->toString(), (string) $adaptation->method, (string) $adaptation->newName);
        }
    }

    public function addTraitUsePrecedence(TraitUsePrecedenceNode $node)
    {
        foreach ($node->insteadof as $insteadof) {
            $this->context->getReflection()->addTraitMethodPrecedences((string) $node->trait->toString(), (string) $insteadof->toString(), (string) $node->method);
        }
    }

    public function addProperty(PropertyNode $node)
    {
        foreach ($node->props as $prop) {
            $property = new ReflectionProperty($prop->name);
            $property->setStartLine((int) $node->getAttribute('startLine'));
            $property->setEndLine((int) $node->getAttribute('endLine'));
            $property->setDocComment((string) $node->getDocComment());
            $property->setStatic((bool) $node->isStatic());

            if (!is_null($prop->default)) {
                $value = $this->resolveValue($prop->default);
                $property->setDefault(strtolower(gettype($value)), $value);
            }

            if ($node->isPrivate()) {
                $property->setVisibility(ReflectionProperty::IS_PRIVATE);
            } elseif ($node->isProtected()) {
                $property->setVisibility(ReflectionProperty::IS_PROTECTED);
            } else {
                $property->setVisibility(ReflectionProperty::IS_PUBLIC);
            }

            $this->context->getReflection()->addProperty($property);
        }
    }

    public function addMethod(ClassMethodNode $node)
    {
        $method = new ReflectionMethod($node->name);
        $method->setStartLine((int) $node->getAttribute('startLine'));
        $method->setEndLine((int) $node->getAttribute('endLine'));
        $method->setDocComment((string) $node->getDocComment());
        $method->setReturnsByRef((bool) $node->returnsByRef());
        $method->setFinal((bool) $node->isFinal());
        $method->setStatic((bool) $node->isStatic());
        $this->addFunctionLikeParameters($method, $node->params);

        // All functions in an interface are implicitly abstract. There is no need to use the abstract keyword when declaring the function.
        if ($this->context->getReflection() instanceof ReflectionInterface) {
            $method->setAbstract(true);
        } else {
            $method->setAbstract((bool) $node->isAbstract());
        }

        if ($node->isPrivate()) {
            $method->setVisibility(ReflectionMethod::IS_PRIVATE);
        } elseif ($node->isProtected()) {
            $method->setVisibility(ReflectionMethod::IS_PROTECTED);
        } else {
            $method->setVisibility(ReflectionMethod::IS_PUBLIC);
        }

        $this->context->getReflection()->addMethod($method);
        $this->context->enterFunctionLike($method);
    }

    public function addConstant(ClassConstNode $node)
    {
        foreach ($node->consts as $const) {
            $constant = new ReflectionConstant($const->name);
            $constant->setStartLine((int) $node->getAttribute('startLine'));
            $constant->setEndLine((int) $node->getAttribute('endLine'));
            $constant->setDocComment((string) $node->getDocComment());
            $constant->setValue($this->resolveValue($const->value));

            $this->context->getReflection()->addConstant($constant);
        }
    }

    public function addFunction(FunctionNode $node)
    {
        $function = new ReflectionFunction((string) $node->namespacedName);
        $function->setFilename((string) $this->context->getFilePath());
        $function->setStartLine((int) $node->getAttribute('startLine'));
        $function->setEndLine((int) $node->getAttribute('endLine'));
        $function->setAliases($this->context->getAliases());
        $function->setDocComment((string) $node->getDocComment());
        $this->addFunctionLikeParameters($function, $node->params);

        $this->context->enterReflection($function);
        $this->context->enterFunctionLike($function);

        return $function;
    }

    protected function addFunctionLikeParameters(ReflectionFunctionAbstract $reflection, array $params)
    {
        foreach ($params as $param) {
            $parameter = new ReflectionParameter($param->name);
            $parameter->setStartLine((int) $param->getAttribute('startLine'));
            $parameter->setEndLine((int) $param->getAttribute('endLine'));
            $parameter->setType((string) $param->type);
            $parameter->setByRef((bool) $param->byRef);
            $parameter->setVariadic((bool) $param->variadic);

            if (!is_null($param->default)) {
                $parameter->setRequired(false);

                if ($param->default->getType() === 'Expr_ConstFetch' && !in_array($param->default->name->toString(), ['null','false','true'])) {
                    $parameter->setDefaultValueConstantName($param->default->name->toString());
                } elseif ($param->default->getType() === 'Expr_ClassConstFetch') {
                    $parameter->setDefaultValueConstantName($param->default->class->toString().'::'.$param->default->name);
                }

                $value = $this->resolveValue($param->default);
                $parameter->setDefault(strtolower(gettype($value)), $value);
            }

            $reflection->addParameter($parameter);
        }
    }

    public function addStaticVariable(StaticNode $node)
    {
        foreach ($node->vars as $var) {
            $value = null;
            if (!is_null($var->default)) {
                $value = $this->resolveValue($var->default);
            }

            $this->context->getFunctionLike()->addStaticVariable($var->name, $value);
        }
    }

    public function addYieldNode(AbstractExprNode $node)
    {
        $this->context->getFunctionLike()->setGenerator(true);
    }

    protected function resolveValue(NodeInterface $nodeValue)
    {
        $type = $nodeValue->getType();
        if (strpos($type, '_MagicConst_')) {
            return $nodeValue->getName();
        }

        $subModules = $nodeValue->getSubNodeNames();
        if (!is_array($subModules) || empty($subModules)) {
            return;
        }

        $subModule = reset($subModules);
        $value     = $nodeValue->$subModule;
        if (is_object($value) && method_exists($value, 'toString')) {
            $value = $value->toString();
        } elseif (is_object($value) && property_exists($value, 'value')) {
            $value = $value->value;
        }

        if (is_array($value)) {
            $newValues = [];
            foreach ($value as $key => $node) {
                $newValues[$this->resolveValue($node->key)] = $this->resolveValue($node->value);
            }

            return $newValues;
        }

        if ($value === 'true') {
            return true;
        } elseif ($value === 'false') {
            return false;
        } elseif ($value === 'null') {
            return;
        }

        return $value;
    }

    protected function buildClassLikeReflection(AbstractNode $node)
    {
        if ($node instanceof InterfaceNode) {
            $class = new ReflectionInterface((string) $node->namespacedName);
        } elseif ($node instanceof TraitNode) {
            $class = new ReflectionTrait((string) $node->namespacedName);
        } else {
            $class = new ReflectionClass((string) $node->namespacedName);
        }

        $class->setFilename((string) $this->context->getFilePath());
        $class->setStartLine((int) $node->getAttribute('startLine'));
        $class->setEndLine((int) $node->getAttribute('endLine'));
        $class->setAliases($this->context->getAliases());
        $class->setDocComment((string) $node->getDocComment());

        $this->context->enterReflection($class);

        return $class;
    }
}
