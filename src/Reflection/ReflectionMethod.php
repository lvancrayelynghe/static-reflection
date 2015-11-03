<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionMethod extends ReflectionFunctionAbstract
{
    use Parts\VisibilityTrait;
    use Parts\StaticTrait;
    use Parts\AbstractTrait;
    use Parts\FinalTrait;
    use Parts\DeclaringClassLikeTrait;

    /**
     * Checks if the method is a constructor.
     *
     * @return bool
     */
    public function isConstructor()
    {
        return $this->getName() === '__construct';
    }

    /**
     * Checks if the method is a destructor.
     *
     * @return bool
     */
    public function isDestructor()
    {
        return $this->getName() === '__destruct';
    }

    /**
     * Returns the methods prototype.
     *
     * @throws \ReflectionException If the method does not have a prototype.
     *
     * @return ReflectionMethod
     */
    public function getPrototype()
    {
        $parent     = $this->getDeclaringClass();
        $methodName = $this->getName();

        while (!is_null($parent)) {
            if ($parent instanceof ReflectionClass || $parent instanceof ReflectionInterface) {
                foreach ($parent->getSelfInterfaces() as $interface) {
                    if ($interface->hasMethod($methodName)) {
                        return $interface->getMethod($methodName);
                    }
                }
            }

            if (!$parent instanceof ReflectionClass) {
                $parent = null;
                continue;
            }

            $parent = $parent->getParentClass();
            if (is_null($parent)) {
                continue;
            }

            if ($parent->hasMethod($methodName) && $parent->getMethod($methodName)->isAbstract()) {
                return $parent->getMethod($methodName);
            }
        }

        throw new \ReflectionException('Method '.$this->getDeclaringClass()->getName().'::'.$this->getName().' does not have a prototype');
    }

    public function getParent()
    {
        $class = $this->getDeclaringClass();

        $methods = [];
        foreach ($class->getSelfMethods() as $methodName => $method) {
            if ($methodName === $this->getName()) {
                $methods[] = $method;
            }
        }

        if ($class instanceof ReflectionClass) {
            foreach ($class->getTraitsMethods() as $methodName => $method) {
                if ($methodName === $this->getName()) {
                    $methods[] = $method;
                }
            }
        }

        if (($class instanceof ReflectionClass || $class instanceof \ReflectionClass) && ($class->getParentClass() instanceof ReflectionClass || $class->getParentClass() instanceof \ReflectionClass)) {
            foreach ($class->getParentClass()->getMethods() as $methodName => $method) {
                if (is_int($methodName)) {
                    $methodName = $method->getName();
                }
                if ($methodName === $this->getName()) {
                    $methods[] = $method;
                }
            }
        }

        if ($class instanceof ReflectionClass || $class instanceof \ReflectionClass) {
            foreach ($class->getInterfaces() as $interfaceName => $interface) {
                foreach ($interface->getMethods() as $methodName => $method) {
                    if ($methodName === $this->getName()) {
                        $methods[] = $method;
                    }
                }
            }
        }

        if (count($methods) >= 2) {
            // $methods[0] is the current method
            return $methods[1];
        }

        return;
    }

    /**
     * Sets a method to be accessible.
     *
     *
     * @param bool $accessible
     *
     * @throws \ReflectionException Always... Can't be implemented.
     */
    public function setAccessible($accessible)
    {
        throw new \ReflectionException('StaticReflection can\'t change a method accessibility');
    }
}
