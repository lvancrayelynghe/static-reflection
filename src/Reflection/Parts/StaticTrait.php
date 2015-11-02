<?php

namespace Benoth\StaticReflection\Reflection\Parts;

trait StaticTrait
{
    protected $isStatic = false;

    public function isStatic()
    {
        return $this->isStatic === true;
    }

    public function setStatic($isStatic)
    {
        $this->isStatic = (bool) $isStatic;

        return $this;
    }
}
