<?php

namespace Benoth\StaticReflection\Reflection\Parts;

use Benoth\StaticReflection\Reflection\ReflectionClassLike;

trait DeclaringClassLikeTrait
{
    protected $declaringClassLike;

    public function getDeclaringClass()
    {
        return $this->declaringClassLike;
    }

    public function getFileName()
    {
        return $this->declaringClassLike->getFileName();
    }

    public function setDeclaringClassLike(ReflectionClassLike $declaringClassLike)
    {
        $this->declaringClassLike = $declaringClassLike;

        return $this;
    }
}
