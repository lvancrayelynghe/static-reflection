<?php

namespace Benoth\StaticReflection\Reflection\Parts;

trait AliasTrait
{
    protected $aliases = [];

    public function getAliases()
    {
        return $this->aliases;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;

        return $this;
    }
}
