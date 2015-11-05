<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionClass extends ReflectionClassLike
{
    use Parts\AbstractTrait;
    use Parts\FinalTrait;
    use Parts\InterfaceTrait;
    use Parts\ConstantTrait;
    use Parts\PropertyTrait;
    use Parts\TraitUseTrait;

    protected $parent;

    public function getParent()
    {
        return $this->parent;
    }

    public function getParentClass()
    {
        if (!$this->getParent()) {
            return;
        }

        // Return internal objects Reflection
        if (class_exists($this->getParent(), false)) {
            $reflection = new \ReflectionClass($this->getParent());
            if ($reflection->isInternal()) {
                return $reflection;
            }
        }

        return $this->index->getClass($this->getParent());
    }

    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isSubclassOf($className)
    {
        if (!is_string($className)) {
            return false;
        }

        $className = ltrim($className, '\\');
        if ($this->hasInterface($className)) {
            return true;
        }

        $parent = $this->getParentClass();
        while ($parent instanceof self) {
            if ($className === $parent->getName()) {
                return true;
            }

            $parent = $parent->getParentClass();
        }

        return false;
    }

    /**
     * Returns if the class is cloneable.
     *
     * @return bool
     */
    public function isCloneable()
    {
        if ($this->hasMethod('__clone')) {
            return $this->getMethod('__clone')->isPublic();
        }

        return true;
    }

    /**
     * Checks if the class is instantiable.
     *
     * @return bool
     */
    public function isInstantiable()
    {
        if ($this->hasMethod('__construct')) {
            return $this->getMethod('__construct')->isPublic();
        }

        return true;
    }

    /**
     * Checks if an object is an instance of the class.
     *
     * @param object $object
     *
     * @return bool
     */
    public function isInstance($object)
    {
        return get_class($object) === $this->getName();
    }

    /**
     * Checks if the class is iterateable.
     *
     * @return bool
     */
    public function isIterateable()
    {
        foreach ($this->getInterfaceNames() as $interfaceName) {
            if (trim($interfaceName, '\\') === 'Iterator') {
                return true;
            }
        }

        return false;
    }

    /**
     * Creates a new class instance from given arguments.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return object
     */
    public function newInstance()
    {
        throw new \ReflectionException('StaticReflection can\'t create instances');
    }

    /**
     * Creates a new instance of the class, the given arguments are passed to the class constructor.
     *
     *
     * @param array $args The parameters to be passed to the class constructor as an array.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return object
     */
    public function newInstanceArgs(array $args)
    {
        throw new \ReflectionException('StaticReflection can\'t create instances');
    }

    /**
     * Creates a new class instance without invoking the constructor.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return object
     */
    public function newInstanceWithoutConstructor()
    {
        throw new \ReflectionException('StaticReflection can\'t create instances');
    }
}
