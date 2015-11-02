<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionInterface extends ReflectionClassLike
{
    use Parts\InterfaceTrait;
    use Parts\ConstantTrait;
}
