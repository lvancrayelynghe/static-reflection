<?php

namespace Benoth\StaticReflection\Reflection;

class ReflectionConstant extends Reflection
{
    use Parts\DeclaringClassLikeTrait;
    use Parts\DocCommentTrait;

    protected $value;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
