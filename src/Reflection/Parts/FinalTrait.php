<?php

namespace Benoth\StaticReflection\Reflection\Parts;

trait FinalTrait
{
    /**
     * @type bool
     */
    protected $isFinal = false;

    /**
     * Checks if a class is final.
     *
     * @return bool
     */
    public function isFinal()
    {
        return $this->isFinal === true;
    }

    /**
     * Sets if a class is final.
     *
     * @param bool $isFinal
     */
    public function setFinal($isFinal)
    {
        $this->isFinal = (bool) $isFinal;

        return $this;
    }
}
