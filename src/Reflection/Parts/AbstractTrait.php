<?php

namespace Benoth\StaticReflection\Reflection\Parts;

trait AbstractTrait
{
    /**
     * @type bool
     */
    protected $isAbstract  = false;

    /**
     * Checks if a class is abstract.
     *
     * @return bool
     */
    public function isAbstract()
    {
        return $this->isAbstract === true;
    }

    /**
     * Sets if a class is abstract.
     *
     * @param bool $isAbstract
     */
    public function setAbstract($isAbstract)
    {
        $this->isAbstract = (bool) $isAbstract;

        return $this;
    }
}
