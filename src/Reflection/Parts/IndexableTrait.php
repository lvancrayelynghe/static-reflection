<?php

namespace Benoth\StaticReflection\Reflection\Parts;

use Benoth\StaticReflection\ReflectionsIndex;

trait IndexableTrait
{
    protected $index;

    public function setIndex(ReflectionsIndex $index)
    {
        $this->index = $index;

        return $this;
    }

    public function getIndex()
    {
        return $this->index;
    }
}
