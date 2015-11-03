<?php

namespace Benoth\StaticReflection\Reflection;

abstract class ReflectionFunctionAbstract extends Reflection
{
    use Parts\DocCommentTrait;

    protected $parameters      = [];
    protected $staticVariables = [];
    protected $returnsByRef    = false;
    protected $isGenerator     = false;

    /**
     * Get the parameters.
     *
     * @return Benoth\StaticReflection\Reflection\ReflectionParameter[string]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get a parameter by its name.
     *
     * @param string $parameterSearchedName The parameter name to reflect
     *
     * @throws \ReflectionException If the parameter does not exist
     *
     * @return Benoth\StaticReflection\Reflection\ReflectionParameter
     */
    public function getParameter($parameterSearchedName)
    {
        foreach ($this->getParameters() as $parameterName => $parameter) {
            if ($parameterName === $parameterSearchedName) {
                return $parameter;
            }
        }

        throw new \ReflectionException('Method '.$parameterSearchedName.' does not exist');
    }

    /**
     * Checks whether the function returns a reference.
     *
     * @return bool
     */
    public function returnsByRef()
    {
        return $this->returnsByRef === true;
    }

    /**
     * Checks whether the function returns a reference.
     *
     * @return bool
     */
    public function returnsReference()
    {
        return $this->returnsByRef();
    }

    /**
     * Get the number of parameters that a function defines, both optional and required.
     *
     * @return int
     */
    public function getNumberOfParameters()
    {
        return count($this->getParameters());
    }

    /**
     * Get the number of required parameters that a function defines.
     *
     * @return int
     */
    public function getNumberOfRequiredParameters()
    {
        $counter = 0;

        foreach ($this->getParameters() as $parameter) {
            if ($parameter->isRequired()) {
                ++$counter;
            }
        }

        return $counter;
    }

    /**
     * Get the static variables.
     *
     * @return array An array of static variables, variable name as key, value as value
     */
    public function getStaticVariables()
    {
        return $this->staticVariables;
    }

    /**
     * Checks whether the reflected function has a return type specified.
     *
     * @return bool
     */
    public function hasReturnType()
    {
        // @todo Implement hasReturnType()
        throw new \ReflectionException('Not implemented yet');
    }

    /**
     * Checks whether the reflected function is a Closure.
     *
     * @return bool
     */
    public function isClosure()
    {
        return false; // We do not reflect closures at the moment
    }

    /**
     * Checks whether the function is deprecated.
     *
     * @return bool
     */
    public function isDeprecated()
    {
        return false; // Always false for user defined functions/methods
    }

    /**
     * Returns whether this function is a generator.
     *
     * @return bool
     */
    public function isGenerator()
    {
        return $this->isGenerator === true;
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
     * Checks if the function is variadic.
     *
     * @return bool
     */
    public function isVariadic()
    {
        foreach ($this->getParameters() as $parameter) {
            if ($parameter->isVariadic()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the scope associated to the closure.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return bool
     */
    public function getClosureScopeClass()
    {
        throw new \ReflectionException('StaticReflection can\'t get closure');
    }

    /**
     * Returns this pointer bound to closure.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return bool
     */
    public function getClosureThis()
    {
        throw new \ReflectionException('StaticReflection can\'t get closure');
    }

    /**
     * Returns a dynamically created closure for the method.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return \Closure|null Returns NULL in case of an error.
     */
    public function getClosure()
    {
        throw new \ReflectionException('StaticReflection can\'t get closure');
    }

    /**
     * Invokes a reflected method.
     *
     *
     * @param object $object    The object to invoke the method on. For static methods, pass null to this parameter.
     * @param mixed  $parameter Zero or more parameters to be passed to the method. It accepts a variable number of parameters which are passed to the method.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return mixed The method result.
     */
    public function invoke($object)
    {
        throw new \ReflectionException('StaticReflection can\'t invoke a method');
    }

    /**
     * Invokes the reflected method and pass its arguments as array.
     *
     * @param object $object The object to invoke the method on. For static methods, pass null to this parameter.
     * @param array  $args   The parameters to be passed to the function, as an array.
     *
     * @throws \ReflectionException Always... Can't be implemented.
     *
     * @return mixed The method result.
     */
    public function invokeArgs($object, array $args)
    {
        throw new \ReflectionException('StaticReflection can\'t invoke a method');
    }

    public function addParameter(ReflectionParameter $parameter)
    {
        $this->parameters[$parameter->getShortName()] = $parameter;
        $parameter->setDeclaringFunction($this);

        return $this;
    }

    public function addStaticVariable($name, $value)
    {
        $this->staticVariables[(string) $name] = $value;

        return $this;
    }

    public function setReturnsByRef($returnsByRef)
    {
        $this->returnsByRef = (bool) $returnsByRef;

        return $this;
    }

    public function setGenerator($isGenerator)
    {
        $this->isGenerator = (bool) $isGenerator;

        return $this;
    }
}
