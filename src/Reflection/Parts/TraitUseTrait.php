<?php

namespace Benoth\StaticReflection\Reflection\Parts;

use Benoth\StaticReflection\Reflection\ReflectionClass;
use Benoth\StaticReflection\Reflection\ReflectionTrait;
use Benoth\StaticReflection\ReflectionsIndex;

trait TraitUseTrait
{
    protected $traits                  = [];
    protected $traitsMethodAliases     = [];
    protected $traitsMethodPrecedences = [];

    /**
     * Must be implemented by classes using this trait
     */
    abstract public function getIndex();

    /**
     * Returns an array of traits used by this class, without traits inherited from parents.
     *
     * Note that getTraits will NOT return any traits inherited from a parent.
     * This is currently viewed as the desired behavior.
     *
     * @see http://php.net/manual/en/reflectionclass.gettraits.php#116513
     * @see self::getAllTraits()
     *
     * @return ReflectionTrait[]
     */
    public function getTraits()
    {
        $traits = $this->getSelfTraits();

        foreach ($traits as $trait) {
            foreach ($trait->getTraits() as $parentTrait) {
                $traits[$parentTrait->getName()] = $parentTrait;
            }
        }

        return $traits;
    }

    /**
     * Returns an array of names of traits used by this class, without traits inherited from parents.
     *
     * This return only the trait names from the current class
     *
     * @see http://php.net/manual/en/reflectionclass.gettraitnames.php#113785
     * @see self::getAllTraitNames()
     *
     * @return string[]
     */
    public function getTraitNames()
    {
        return $this->traits;
    }

    /**
     * Returns an array of traits used by this class, with traits inherited from parents.
     *
     * @return ReflectionTrait[]
     */
    public function getAllTraits()
    {
        $traits = $this->getTraits();

        if ($this instanceof ReflectionClass && $this->getParentClass() instanceof ReflectionClass) {
            foreach ($this->getParentClass()->getAllTraits() as $trait) {
                if (!array_key_exists($trait->getName(), $traits)) {
                    $traits[$trait->getName()] = $trait;
                }
            }
        }

        return $traits;
    }

    /**
     * Returns an array of names of traits used by this class, with traits inherited from parents.
     *
     * @return string[]
     */
    public function getAllTraitNames()
    {
        $names = [];

        foreach ($this->getAllTraits() as $trait) {
            $names[] = $trait->getName();
        }

        return $names;
    }

    /**
     * Gets the traits, without inherited ones.
     *
     * @return ReflectionTrait[]
     */
    public function getSelfTraits()
    {
        $traits = [];

        if (!$this->getIndex() instanceof ReflectionsIndex) {
            return $traits;
        }

        foreach ($this->traits as $trait) {
            $trait = $this->getIndex()->getTrait($trait);
            if (!$trait instanceof ReflectionTrait) {
                continue;
            }
            $traits[$trait->getName()] = $trait;
        }

        return $traits;
    }

    /**
     * Gets an array of properties defined in class traits, with inherited ones.
     *
     * @return \Benoth\StaticReflection\Reflection\ReflectionProperty[]
     */
    public function getTraitsProperties()
    {
        $properties = [];

        foreach ($this->getAllTraits() as $trait) {
            if (!$trait instanceof ReflectionTrait) {
                continue;
            }
            foreach ($trait->getProperties() as $property) {
                if (!array_key_exists($property->getName(), $properties)) {
                    $properties[$property->getName()] = $property;
                }
            }
        }

        return $properties;
    }

    /**
     * Gets an array of methods defined in class traits, including inherited ones.
     *
     * @return Benoth\StaticReflection\Reflection\ReflectionMethod[]
     */
    public function getTraitsMethods()
    {
        $methods = [];

        foreach ($this->getAllTraits() as $traitName => $trait) {
            if (!$trait instanceof ReflectionTrait) {
                continue;
            }
            foreach ($trait->getMethods() as $method) {
                $alias = $this->getAliasedMethodName($traitName, $method->getName());
                if (!$this->isReplacedByPrecedence($traitName, $method->getName())) {
                    $methods[$alias] = $method;
                } elseif (!array_key_exists($alias, $methods)) {
                    $methods[$alias] = $method;
                }
            }
        }

        return $methods;
    }

    /**
     * Returns an array of trait methods aliases.
     *
     * @return string[] New method names in keys and original names (in the format "TraitName::original") in values
     */
    public function getTraitAliases()
    {
        $aliases = [];

        foreach ($this->getTraitMethodAlias() as $alias) {
            $aliases[$alias['newName']] = $alias['trait'].'::'.$alias['oldName'];
        }

        return $aliases;
    }

    /**
     * Returns an array of trait methods aliases.
     *
     * @return array[] Numeric keys with 3 values associative array : trait (name of the trait), oldName (old method name), newName (new method name)
     */
    public function getTraitMethodAlias()
    {
        return $this->traitsMethodAliases;
    }

    /**
     * Returns an array of trait methods precedences.
     *
     * @return array[] Numeric keys with 3 values associative array : trait (name of the trait used), insteadof (name of the trait replaced), method (method name)
     */
    public function getTraitMethodPrecedences()
    {
        return $this->traitsMethodPrecedences;
    }

    /**
     * Gets a method aliased name.
     *
     * @param string $traitName  Fully Qualified Name of the trait
     * @param string $methodName Name of the method
     *
     * @return string Aliased name or the method original name il no alias found
     */
    public function getAliasedMethodName($traitName, $methodName)
    {
        foreach ($this->getTraitMethodAlias() as $alias) {
            if ($traitName === $alias['trait'] && $methodName === $alias['oldName']) {
                return $alias['newName'];
            }
        }

        return $methodName;
    }

    /**
     * Check if a method from a trait is replaced by precedence.
     *
     * @param string $traitName  Fully Qualified Name of the trait
     * @param string $methodName
     *
     * @return bool
     */
    public function isReplacedByPrecedence($traitName, $methodName)
    {
        foreach ($this->getTraitMethodPrecedences() as $precedence) {
            if ($traitName === $precedence['insteadof'] && $methodName === $precedence['method']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add a trait use on the current entity.
     *
     * @param string $trait Fully Qualified Trait Name
     *
     * @return self
     */
    public function addTrait($trait)
    {
        $this->traits[] = (string) $trait;

        return $this;
    }

    /**
     * Add a trait method alias.
     *
     * @param string $trait   Fully Qualified Name of the trait
     * @param string $oldName Old method name
     * @param string $newName New method name
     *
     * @return self
     */
    public function addTraitMethodAlias($trait, $oldName, $newName)
    {
        $this->traitsMethodAliases[] = [
            'trait'   => (string) $trait,
            'oldName' => (string) $oldName,
            'newName' => (string) $newName,
        ];

        return $this;
    }

    /**
     * Add a trait method precedence.
     *
     * @param string $trait     Fully Qualified Name of the trait to use
     * @param string $insteadof Fully Qualified Name of the replaced trait
     * @param string $method    Method name
     */
    public function addTraitMethodPrecedences($trait, $insteadof, $method)
    {
        $this->traitsMethodPrecedences[] = [
            'trait'     => (string) $trait,
            'insteadof' => (string) $insteadof,
            'method'    => (string) $method,
        ];

        return $this;
    }
}
