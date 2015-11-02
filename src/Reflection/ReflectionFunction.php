<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionFunction extends ReflectionFunctionAbstract
{
    use Parts\AliasTrait;
    use Parts\IndexableTrait;

    /**
     * Checks if the function is disabled, via the disable_functions directive.
     *
     * @return bool
     */
    public function isDisabled()
    {
        return false; // Always false for user defined functions
    }
}
