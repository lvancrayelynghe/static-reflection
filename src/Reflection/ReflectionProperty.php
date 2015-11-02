<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionProperty extends Reflection
{
    use Parts\VisibilityTrait;
    use Parts\StaticTrait;
    use Parts\DeclaringClassLikeTrait;
    use Parts\DocCommentTrait;

    protected $defaultType  = 'null';
    protected $defaultValue = null;

    /**
     * Gets the property's default type and value.
     *
     * @return array Type at index 0 and Value at index 1
     */
    public function getDefault()
    {
        return [$this->defaultType, $this->defaultValue];
    }

    /**
     * Gets the property's default type.
     *
     * @return string
     */
    public function getDefaultType()
    {
        return $this->defaultType;
    }

    /**
     * Gets the property's default value.
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Sets the property's default value and type.
     *
     * @param string $type
     * @param mixed  $value
     */
    public function setDefault($type, $value)
    {
        $this->defaultType  = $type;
        $this->defaultValue = $value;

        return $this;
    }

    /**
     * Gets the property's value.
     *
     * @param object $object If the property is non-static an object must be provided to fetch the property from
     *
     * @throws \ReflectionException If something is received in parameter
     *
     * @return mixed
     */
    public function getValue($object = null)
    {
        if (!is_null($object)) {
            throw new \ReflectionException('StaticReflection can\'t fetch objects');
        }

        return $this->getDefaultValue();
    }

    /**
     * Checks whether the property was declared at compile-time or was dynamically declared at run-time.
     *
     * @return bool If the property was declared at compile-time
     */
    public function isDefault()
    {
        return true; // There's no instanciation with static reflection, so the property is always set at compile time
    }

    /**
     * Set property accessibility.
     *
     * @param bool $accessible
     *
     * @throws \ReflectionException Always... Can't be implemented
     *
     * @return bool
     */
    public function setAccessible($accessible)
    {
        throw new \ReflectionException('StaticReflection can\'t change property accessibility');
    }

    /**
     * Set property value.
     *
     * @param mixed $objectOrValue
     * @param mixed $value
     *
     * @throws \ReflectionException Always... Can't be implemented
     */
    public function setValue($objectOrValue, $value = null)
    {
        throw new \ReflectionException('StaticReflection can\'t change a property value');
    }
}
