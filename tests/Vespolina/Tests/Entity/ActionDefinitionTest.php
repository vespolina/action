<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Tests\Entity\Action\Manager;

use Vespolina\Action\Manager\ActionManager;
use Vespolina\Entity\Action\ActionDefinition;

/**
 */
class ActionDefinitionTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $actionDefinition = new ActionDefinition('orderPaintForCar', 'car');
       
        $this->assertEquals($actionDefinition->getName(), 'orderPaintForCar');
        $this->assertEquals($actionDefinition->getTopic(), 'car');
        
    }

}
