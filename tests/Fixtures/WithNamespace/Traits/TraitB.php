<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits;

trait TraitB
{
    /**
     * @type int
     */
    public $staticPropertyTraitB = 1;
    public $property1TraitB      = false;

    public function publicMethodTraitB()
    {
    }

    public function common()
    {
    }

    public function commonTraits()
    {
    }
}
