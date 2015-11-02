<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionParameter extends Reflection
{
    protected $declaringFunction;
    protected $type;
    protected $byRef;
    protected $required     = true;
    protected $variadic     = false;
    protected $defaultType  = 'null';
    protected $defaultValue = null;
    protected $constantName = null;

    /**
     * Gets the declaring function or method.
     *
     * @return ReflectionFunction
     */
    public function getDeclaringFunction()
    {
        return $this->declaringFunction;
    }

    /**
     * Gets the declaring class for a method.
     *
     * @return ReflectionClass|ReflectionTrait|ReflectionInterface|null Always null for a function
     */
    public function getDeclaringClass()
    {
        if ($this->declaringFunction instanceof ReflectionFunction) {
            return;
        }

        return $this->declaringFunction->getDeclaringClass();
    }

    public function getFileName()
    {
        return $this->declaringFunction->getFileName();
    }

    /**
     * Checks if the parameter is passed in by reference.
     *
     * @return bool
     */
    public function isByRef()
    {
        return $this->byRef;
    }

    /**
     * Checks if the parameter is passed in by reference.
     *
     * @return bool
     */
    public function isPassedByReference()
    {
        return $this->isByRef();
    }

    /**
     * Checks if the parameter can be passed by value.
     *
     * @return bool
     */
    public function canBePassedByValue()
    {
        return !$this->isByRef();
    }

    /**
     * Checks if the parameter is required.
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Checks if the parameter is declared as a variadic parameter.
     *
     * @return bool
     */
    public function isVariadic()
    {
        return $this->variadic;
    }

    /**
     * Checks if the parameter is optional.
     *
     * @return bool
     */
    public function isOptional()
    {
        return !$this->required;
    }

    /**
     * Gets the associated type of a parameter.
     *
     * @return ReflectionType ReflectionType if a parameter type is specified, null otherwise.
     */
    public function getType()
    {
        // @todo Handle ReflectionType ?
        return $this->type;
    }

    /**
     * Gets the class type hinted for the parameter as a ReflectionClass object.
     *
     * @return ReflectionClass
     */
    public function getClass()
    {
        return $this->getIndex()->getClass($this->getType());
    }

    /**
     * Checks if the parameter has a type associated with it.
     *
     * @return bool
     */
    public function hasType()
    {
        // @todo Handle ReflectionType ?
        return $this->getType() !== null;
    }

    /**
     * Checks if the parameter expects an array.
     *
     * @return bool
     */
    public function isArray()
    {
        // @todo Handle ReflectionType ?
        return $this->getType() == 'array';
    }

    /**
     * Checks if the parameter expects a callable.
     *
     * @return bool
     */
    public function isCallable()
    {
        // @todo Handle ReflectionType ?
        return $this->getType() == 'callable';
    }

    /**
     * Checks whether the parameter allows NULL.
     *
     * @return bool
     */
    public function allowsNull()
    {
        if ($this->getType() === null) {
            return true;
        }

        if ($this->isOptional()) {
            return true;
        }

        return $this->defaultValue === null;
    }

    /**
     * Checks if a default value for the parameter is available.
     *
     * @return bool
     */
    public function isDefaultValueAvailable()
    {
        return !$this->isRequired();
    }

    public function getDefault()
    {
        return [$this->defaultType, $this->defaultValue];
    }

    public function getDefaultType()
    {
        return $this->defaultType;
    }

    /**
     * Gets default parameter value.
     *
     * @throws \ReflectionException If the parameter is required
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        if ($this->isRequired()) {
            throw new \ReflectionException('Parameter '.$this->getName().' is required and does not have a default value');
        }

        return $this->defaultValue;
    }

    /**
     * Returns the default value's constant name if default value is constant or null.
     *
     * @return string|null
     */
    public function getDefaultValueConstantName()
    {
        return $this->constantName;
    }

    /**
     * Returns whether the default value of this parameter is a named constant.
     *
     * @return bool
     */
    public function isDefaultValueConstant()
    {
        return !is_null($this->constantName);
    }

    /**
     * Gets the position of the parameter.
     *
     * The position of the parameter, left to right, starting at position #0.
     *
     * @return int
     */
    public function getPosition()
    {
        foreach ($this->getDeclaringFunction()->getParameters() as $position => $parameter) {
            if ($this === $parameter) {
                return $position;
            }
        }
    }

    public function setDeclaringFunction(ReflectionFunctionAbstract $declaringFunction)
    {
        $this->declaringFunction = $declaringFunction;

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setByRef($byRef)
    {
        $this->byRef = (bool) $byRef;

        return $this;
    }

    public function setRequired($required)
    {
        $this->required = (bool) $required;

        return $this;
    }

    public function setVariadic($variadic)
    {
        $this->variadic = (bool) $variadic;

        return $this;
    }

    public function setDefault($type, $value)
    {
        $this->defaultType  = $type;
        $this->defaultValue = $value;

        return $this;
    }

    public function setDefaultValueConstantName($constantName)
    {
        $this->constantName = $constantName;

        return $this;
    }
}
