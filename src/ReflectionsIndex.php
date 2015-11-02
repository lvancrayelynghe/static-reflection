<?php

namespace Benoth\StaticReflection;

use Benoth\StaticReflection\Reflection\Reflection;
use Benoth\StaticReflection\Reflection\ReflectionClass;
use Benoth\StaticReflection\Reflection\ReflectionClassLike;
use Benoth\StaticReflection\Reflection\ReflectionFunction;
use Benoth\StaticReflection\Reflection\ReflectionInterface;
use Benoth\StaticReflection\Reflection\ReflectionTrait;

class ReflectionsIndex
{
    protected $reflections = [];

    public function addReflection(Reflection $reflection)
    {
        $reflection->setIndex($this);

        $this->reflections[] = $reflection;
    }

    public function getReflections()
    {
        return $this->reflections;
    }

    public function getClassLikes()
    {
        return array_filter($this->reflections, function ($reflection) {
            return $reflection instanceof ReflectionClassLike;
        });
    }

    public function getClasses()
    {
        return array_filter($this->reflections, function ($reflection) {
            return $reflection instanceof ReflectionClass;
        });
    }

    public function getInterfaces()
    {
        return array_filter($this->reflections, function ($reflection) {
            return $reflection instanceof ReflectionInterface;
        });
    }

    public function getTraits()
    {
        return array_filter($this->reflections, function ($reflection) {
            return $reflection instanceof ReflectionTrait;
        });
    }

    public function getFunctionLikes()
    {
        $functions = array_filter($this->reflections, function ($reflection) {
            return $reflection instanceof ReflectionFunction;
        });

        foreach ($this->getClassLikes() as $reflection) {
            $functions = array_merge($functions, $reflection->getMethods());
        }

        return $functions;
    }

    public function getFunctions()
    {
        return array_filter($this->reflections, function ($reflection) {
            return $reflection instanceof ReflectionFunction;
        });
    }

    /**
     * Get a class by its Fully Qualified Name.
     *
     * @param string $className Fully Qualified Name
     *
     * @return ReflectionClass|null
     */
    public function getClass($className)
    {
        foreach ($this->getClasses() as $reflection) {
            if ($reflection->getName() === $className) {
                return $reflection;
            }
        }

        return;
    }

    /**
     * Get an interface by its Fully Qualified Name.
     *
     * @param string $interfaceName Fully Qualified Name
     *
     * @return ReflectionInterface|null
     */
    public function getInterface($interfaceName)
    {
        foreach ($this->getInterfaces() as $reflection) {
            if ($reflection->getName() === $interfaceName) {
                return $reflection;
            }
        }

        return;
    }

    /**
     * Get a trait by its Fully Qualified Name.
     *
     * @param string $traitName Fully Qualified Name
     *
     * @return ReflectionTrait|null
     */
    public function getTrait($traitName)
    {
        foreach ($this->getTraits() as $reflection) {
            if ($reflection->getName() === $traitName) {
                return $reflection;
            }
        }

        return;
    }

    public function getFunction($functionName)
    {
        foreach ($this->getFunctions() as $reflection) {
            if ($reflection->getName() === $functionName) {
                return $reflection;
            }
        }

        return;
    }
}
