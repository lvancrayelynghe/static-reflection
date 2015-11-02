<?php

namespace Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Classes;

use Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\InterfaceA;
use Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Interfaces\InterfaceC as InterfaceRenamed;
use Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitA;
use Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitB;
use Benoth\StaticReflection\Tests\Fixtures\WithNamespace\Traits\TraitC as TraitRenamed;

final class ClassComplete extends AbstractStaticFinalMethods implements InterfaceA, InterfaceRenamed
{
    const COMMON     = 666;
    const FROM_CLASS = 'from class';

    use TraitRenamed;

    // @todo Missing a test for this case
    // use TraitB {
    // 	common as commonFromTraitB;
    // }

    use TraitA, TraitB {
        TraitA::commonTraits insteadof TraitB;
        TraitB::common as commonFromTraitB;
    }

    /**
     * @type bool
     */
    public static $publicStaticPropComplete = true;
    public static $property1TraitB          = 'override !';

    public function common()
    {
        //
    }

    public function publicMethodInterfaceA($var1)
    {
        return $var1;
    }
}
