<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits;

trait TraitA
{
    public $staticPropertyTraitA = [];
    public $property1TraitA      = 1;
    protected $property2TraitA   = true;
    private $property3TraitA     = 'a string';

    public function publicMethodTraitA()
    {
    }

    private function privateMethodTraitA()
    {
    }

    public static function publicStaticMethodTraitA()
    {
    }

    public function common()
    {
    }

    public function commonTraits()
    {
    }
}
