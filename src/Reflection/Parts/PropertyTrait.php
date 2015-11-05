<?php

namespace Benoth\StaticReflection\Reflection\Parts;

use Benoth\StaticReflection\Reflection\ReflectionClass;
use Benoth\StaticReflection\Reflection\ReflectionProperty;

trait PropertyTrait
{
    protected $properties = [];

    /**
     * Gets the fully qualified entity name (with the namespace).
     *
     * Must be implemented by classes using this trait
     *
     * @return string
     */
    abstract public function getName();


    /**
     * Gets the filename of the file in which the class has been defined.
     *
     * Must be implemented by classes using this trait.
     *
     * @return string
     */
    abstract public function getFileName();

    /**
     * Gets an array of properties, with inherited ones.
     *
     * @param int $filter Any combination of ReflectionProperty::IS_STATIC, ReflectionProperty::IS_PUBLIC, ReflectionProperty::IS_PROTECTED, ReflectionProperty::IS_PRIVATE.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionProperty[]
     */
    public function getProperties($filter = null)
    {
        $properties = $this->getSelfProperties();

        if ($this instanceof ReflectionClass && $this->getParentClass() instanceof ReflectionClass) {
            foreach ($this->getParentClass()->getProperties() as $property) {
                if (!array_key_exists($property->getName(), $properties)) {
                    $properties[$property->getName()] = $property;
                }
            }
        }

        if ($this instanceof ReflectionClass) {
            foreach ($this->getTraitsProperties() as $propertyName => $property) {
                if (!array_key_exists($propertyName, $properties)) {
                    $properties[$propertyName] = $property;
                }
            }
        }

        return $this->filterProperties($properties, $filter);
    }

    /**
     * Gets an array of static properties, with inherited ones.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionProperty[]
     */
    public function getStaticProperties()
    {
        return $this->getProperties(ReflectionProperty::IS_STATIC);
    }

    /**
     * Gets an array of properties, without inherited ones.
     *
     * @param int $filter Any combination of ReflectionProperty::IS_STATIC, ReflectionProperty::IS_PUBLIC, ReflectionProperty::IS_PROTECTED, ReflectionProperty::IS_PRIVATE.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionProperty[]
     */
    public function getSelfProperties($filter = null)
    {
        $properties = [];
        foreach ($this->properties as $property) {
            $properties[$property->getName()] = $property;
        }

        return $this->filterProperties($properties, $filter);
    }

    /**
     * Gets a ReflectionProperty for an entity.
     *
     * @param string $propertySearchedName The property name to reflect
     *
     * @throws \ReflectionException If the property does not exist
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionProperty
     */
    public function getProperty($propertySearchedName)
    {
        foreach ($this->getProperties() as $propertyName => $property) {
            if ($propertyName === $propertySearchedName) {
                return $property;
            }
        }

        throw new \ReflectionException('Property '.$propertySearchedName.' does not exist');
    }

    /**
     * Checks if a property is defined.
     *
     * @param string $propertySearchedName Name of the property being checked for
     *
     * @return bool
     */
    public function hasProperty($propertySearchedName)
    {
        foreach ($this->getProperties() as $propertyName => $property) {
            if ($propertyName === $propertySearchedName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets default properties values, with inherited ones.
     *
     * @return mixed[]
     */
    public function getDefaultProperties()
    {
        $properties = [];
        foreach ($this->getProperties() as $propertyName => $property) {
            $properties[$propertyName] = $property->getDefaultValue();
        }

        return $properties;
    }

    /**
     * Gets static property value.
     *
     * @param string $name    The name of the static property
     * @param mixed  $default Optional default value to return if the property does not exist
     *
     * @throws \ReflectionException If the property does not exist and default value is omitted.
     *
     * @return mixed The static property value or the default value if provided and if the property does not exist
     */
    public function getStaticPropertyValue($name)
    {
        if (func_num_args() === 2) {
            $default = func_get_arg(1);
        }

        $properties = $this->getStaticProperties();
        if (!array_key_exists($name, $properties) && !isset($default)) {
            throw new \ReflectionException('Class '.$this->getName().' does not have a property named '.$name);
        } elseif (!array_key_exists($name, $properties)) {
            return $default;
        }

        return $properties[$name]->getDefaultValue();
    }

    /**
     * Sets static property value.
     *
     * @param string $name  The property name
     * @param string $value The new value
     *
     * @throws \ReflectionException If the property does not exist or is not public
     */
    public function setStaticPropertyValue($name, $value)
    {
        $property = $this->getProperty($name);
        if (!$property->isPublic() || !$property->isStatic()) {
            throw new \ReflectionException('Class '.$this->getName().' does not have a property named '.$name);
        }

        $property->setDefault(gettype($value), $value);
    }

    /**
     * Add a property to the reflected class.
     *
     * @param ReflectionProperty $property
     */
    public function addProperty(ReflectionProperty $property)
    {
        $this->properties[$property->getShortName()] = $property;
        $property->setDeclaringClassLike($this);
        $property->setFilename($this->getFileName());

        return $this;
    }

    /**
     * Filter an array of properties.
     *
     * @param \Benoth\StaticReflection\Reflection\ReflectionProperty[] $properties
     * @param int                                                      $filter     Any combination of ReflectionProperty::IS_STATIC, ReflectionProperty::IS_PUBLIC, ReflectionProperty::IS_PROTECTED, ReflectionProperty::IS_PRIVATE.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionProperty[]
     */
    protected function filterProperties(array $properties, $filter)
    {
        if (!is_int($filter)) {
            return $properties;
        }

        return array_filter($properties, function (ReflectionProperty $property) use ($filter) {
            if (self::IS_PRIVATE === (self::IS_PRIVATE & $filter) && $property->isPrivate()) {
                return true;
            } elseif (self::IS_PROTECTED === (self::IS_PROTECTED & $filter) && $property->isProtected()) {
                return true;
            } elseif (self::IS_PUBLIC === (self::IS_PUBLIC & $filter) && $property->isPublic()) {
                return true;
            } elseif (self::IS_STATIC === (self::IS_STATIC & $filter) && $property->isStatic()) {
                return true;
            }

            return false;
        });
    }
}
