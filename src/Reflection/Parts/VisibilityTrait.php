<?php

namespace Benoth\StaticReflection\Reflection\Parts;

use Benoth\StaticReflection\Reflection\Reflection;

trait VisibilityTrait
{
    protected $visibility = Reflection::IS_PUBLIC;

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function isPublic()
    {
        return $this->getVisibility() === self::IS_PUBLIC;
    }

    public function isProtected()
    {
        return $this->getVisibility() === self::IS_PROTECTED;
    }

    public function isPrivate()
    {
        return $this->getVisibility() === self::IS_PRIVATE;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = (int) $visibility;

        return $this;
    }
}
