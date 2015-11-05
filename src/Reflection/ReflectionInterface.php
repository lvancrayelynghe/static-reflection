<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionInterface extends ReflectionClassLike
{
    use Parts\InterfaceTrait;
    use Parts\ConstantTrait;

    /**
     * {@inheritdoc}
     */
    public function isSubclassOf($className)
    {
        if (!is_string($className)) {
            return false;
        }

        return $this->hasInterface($className);
    }
}
