<?php

namespace Benoth\StaticReflection\Reflection\Parts;

use Benoth\StaticReflection\Reflection\ReflectionInterface;
use Benoth\StaticReflection\ReflectionsIndex;

trait InterfaceTrait
{
    /**
     * @type string[]
     */
    protected $interfaces = [];

    /**
     * Must be implemented by classes using this trait
     */
    abstract public function getIndex();

    /**
     * Gets the interfaces, including inherited ones.
     *
     * @return ReflectionInterface[]
     */
    public function getInterfaces()
    {
        $interfaces = $this->getSelfInterfaces();

        foreach ($interfaces as $interface) {
            foreach ($interface->getInterfaces() as $parentInterface) {
                $interfaces[$parentInterface->getName()] = $parentInterface;
            }
        }

        return $interfaces;
    }

    /**
     * Gets the interfaces, without inherited ones.
     *
     * @return ReflectionInterface[]
     */
    public function getSelfInterfaces()
    {
        $interfaces = [];

        if (!$this->getIndex() instanceof ReflectionsIndex) {
            return $interfaces;
        }

        foreach ($this->interfaces as $interface) {
            $interface = $this->getIndex()->getInterface($interface);
            if (!$interface instanceof ReflectionInterface) {
                continue;
            }
            $interfaces[$interface->getName()] = $interface;
        }

        return $interfaces;
    }

    /**
     * Gets the interfaces names, including inherited ones.
     *
     * @return string[] A numerical array with interface names as the values
     */
    public function getInterfaceNames()
    {
        $interfaces = $this->interfaces;

        foreach ($this->getInterfaces() as $interface) {
            if (!in_array($interface->getName(), $interfaces)) {
                $interfaces[] = $interface->getName();
            }
        }

        return $interfaces;
    }

    /**
     * Check whether current entity implements or extends an interface
     *
     * @param  string  $interfaceName The interface fully qualified name
     *
     * @return bool
     */
    public function hasInterface($interfaceName)
    {
        $interfaceName = ltrim($interfaceName, '\\');
        foreach ($this->getInterfaces() as $interface) {
            if ($interfaceName === $interface->getName()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add an interface.
     *
     * @param string $interface Fully Qualified Interface Name
     *
     * @return self
     */
    public function addInterface($interface)
    {
        $this->interfaces[] = $interface;

        return $this;
    }
}
