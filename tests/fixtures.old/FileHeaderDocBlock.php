<?php

/**
 * This file is part of DocBlockAnalyser.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Luc Vancrayelynghe <luc@ppgm.fr>
 * @license   https://opensource.org/licenses/MIT MIT License
 *
 * @link      http://www.docblockanalyser.org
 */
namespace Benoth\StaticReflection\Tests\Fixtures;

class FileHeaderDocBlock extends Not\Existing\ClassWhatEver implements Not\Existing\InterfaceWhatEver
{
    use Not\Existing\TraitWhatEver;

    public function __construct()
    {
        //
    }
}
