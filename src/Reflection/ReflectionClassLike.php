<?php

namespace Benoth\StaticReflection\Reflection;

abstract class ReflectionClassLike extends Reflection
{
    use Parts\AliasTrait;
    use Parts\DocCommentTrait;
    use Parts\IndexableTrait;

    protected $methods = [];

    /**
     * Checks if the class is a subclass of the specified class or implements a specified interface.
     *
     * @param string $className
     *
     * @return bool
     */
    public function isSubclassOf($className)
    {
        return false;
    }

    /**
     * Gets an array of methods, including inherited ones.
     *
     * @param int $filter Any combination of ReflectionMethod::IS_STATIC, ReflectionMethod::IS_PUBLIC, ReflectionMethod::IS_PROTECTED, ReflectionMethod::IS_PRIVATE, ReflectionMethod::IS_ABSTRACT, ReflectionMethod::IS_FINAL.
     *
     * @return Benoth\StaticReflection\Reflection\ReflectionMethod[]
     */
    public function getMethods($filter = null)
    {
        // The order needs to be 1) current class, 2) traits, 3) parent class, 4) interfaces
        $methods = $this->getSelfMethods();

        if ($this instanceof ReflectionClass || $this instanceof ReflectionTrait) {
            foreach ($this->getTraitsMethods() as $methodName => $method) {
                if (!array_key_exists($methodName, $methods)) {
                    $methods[$methodName] = $method;
                }
            }
        }

        if ($this instanceof ReflectionClass && ($this->getParentClass() instanceof ReflectionClass || $this->getParentClass() instanceof \ReflectionClass)) {
            foreach ($this->getParentClass()->getMethods() as $methodName => $method) {
                if (is_int($methodName)) {
                    $methodName = $method->getName();
                }
                if (!array_key_exists($methodName, $methods)) {
                    $methods[$methodName] = $method;
                }
            }
        }

        if ($this instanceof ReflectionClass || $this instanceof ReflectionInterface) {
            foreach ($this->getInterfaces() as $interfaceName => $interface) {
                foreach ($interface->getMethods() as $methodName => $method) {
                    if (!array_key_exists($methodName, $methods)) {
                        $methods[$methodName] = $method;
                    }
                }
            }
        }

        return $this->filterMethods($methods, $filter);
    }

    /**
     * Gets an array of methods, without inherited ones.
     *
     * @param int $filter Any combination of ReflectionMethod::IS_STATIC, ReflectionMethod::IS_PUBLIC, ReflectionMethod::IS_PROTECTED, ReflectionMethod::IS_PRIVATE, ReflectionMethod::IS_ABSTRACT, ReflectionMethod::IS_FINAL.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionMethod[]
     */
    public function getSelfMethods($filter = null)
    {
        $methods = [];
        foreach ($this->methods as $method) {
            $methods[$method->getName()] = $method;
        }

        return $this->filterMethods($methods, $filter);
    }

    /**
     * Gets a ReflectionMethod for a class method.
     *
     * @param string $methodSearchedName The method name to reflect
     *
     * @throws \ReflectionException If the method does not exist
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionMethod
     */
    public function getMethod($methodSearchedName)
    {
        foreach ($this->getMethods() as $methodName => $method) {
            if ($methodName === $methodSearchedName) {
                return $method;
            }
        }

        throw new \ReflectionException('Method '.$methodSearchedName.' does not exist');
    }

    /**
     * Gets the constructor of the reflected class.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionMethod
     */
    public function getConstructor()
    {
        try {
            return $this->getMethod('__construct');
        } catch (\ReflectionException $e) {
            return;
        }
    }

    /**
     * Checks if a method is defined.
     *
     * @param string $methodSearchedName Name of the method being checked for
     *
     * @return bool
     */
    public function hasMethod($methodSearchedName)
    {
        foreach ($this->getMethods() as $methodName => $method) {
            if ($methodName === $methodSearchedName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if current entity implements an interface.
     *
     * @param string $interface The interface name
     *
     * @return bool
     */
    public function implementsInterface($interfaceSearchedName)
    {
        $interfaceSearchedName = trim($interfaceSearchedName, '\\');
        foreach ($this->getInterfaceNames() as $interfaceName) {
            if (trim($interfaceName, '\\') === $interfaceSearchedName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add a method to the reflected class.
     *
     * @param ReflectionMethod $method
     */
    public function addMethod(ReflectionMethod $method)
    {
        $this->methods[$method->getShortName()] = $method;
        $method->setDeclaringClassLike($this);
        $method->setFilename($this->getFileName());

        return $this;
    }

    /**
     * Gets a ReflectionExtension object for the extension which defined the class.
     *
     * @return null|\ReflectionExtension
     */
    public function getExtension()
    {
        return; // Always null for user-defined classes
    }

    /**
     * Gets the name of the extension which defined the class.
     *
     * @return bool
     */
    public function getExtensionName()
    {
        return false; // Always false for user-defined classes
    }

    /**
     * Checks if class is defined internally by an extension, or the core.
     *
     * @return bool
     */
    public function isInternal()
    {
        return false; // Always false for user-defined classes
    }

    /**
     * Checks if class is user defined.
     *
     * @return bool
     */
    public function isUserDefined()
    {
        return true; // Always true for user-defined classes
    }

    /**
     * Checks if the entity is a class.
     *
     * @return bool
     */
    public function isClass()
    {
        return $this instanceof ReflectionClass;
    }

    /**
     * Checks if the entity is an interface.
     *
     * @return bool
     */
    public function isInterface()
    {
        return $this instanceof ReflectionInterface;
    }

    /**
     * Checks if the entity is a trait.
     *
     * @return bool
     */
    public function isTrait()
    {
        return $this instanceof ReflectionTrait;
    }

    /**
     * Filter an array of methods.
     *
     * @param \Benoth\StaticReflection\Reflection\ReflectionMethod[] $methods
     * @param int                                                    $filter  Any combination of ReflectionMethod::IS_STATIC, ReflectionMethod::IS_PUBLIC, ReflectionMethod::IS_PROTECTED, ReflectionMethod::IS_PRIVATE, ReflectionMethod::IS_ABSTRACT, ReflectionMethod::IS_FINAL.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionMethod[]
     */
    protected function filterMethods(array $methods, $filter)
    {
        if (!is_int($filter)) {
            return $methods;
        }

        return array_filter($methods, function (ReflectionMethod $method) use ($filter) {
            if (self::IS_PRIVATE === (self::IS_PRIVATE & $filter) && $method->isPrivate()) {
                return true;
            } elseif (self::IS_PROTECTED === (self::IS_PROTECTED & $filter) && $method->isProtected()) {
                return true;
            } elseif (self::IS_PUBLIC === (self::IS_PUBLIC & $filter) && $method->isPublic()) {
                return true;
            } elseif (self::IS_FINAL === (self::IS_FINAL & $filter) && $method->isFinal()) {
                return true;
            } elseif (self::IS_ABSTRACT === (self::IS_ABSTRACT & $filter) && $method->isAbstract()) {
                return true;
            } elseif (self::IS_STATIC === (self::IS_STATIC & $filter) && $method->isStatic()) {
                return true;
            }

            return false;
        });
    }
}
