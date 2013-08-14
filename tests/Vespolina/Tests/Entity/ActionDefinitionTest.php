<?php

namespace Vespolina\Entity\Action\Tests\Manager;

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
