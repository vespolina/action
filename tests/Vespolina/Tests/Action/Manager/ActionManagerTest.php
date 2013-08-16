<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Action\Tests\Manager;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Vespolina\Action\Manager\ActionManager;
use Vespolina\Action\Gateway\ActionMemoryGateway;
use Vespolina\Entity\Action\Action;
use Vespolina\Entity\Action\ActionDefinition;


/**
 */
class ActionManagerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->manager = new ActionManager(new ActionMemoryGateway(), new EventDispatcher());
    }
    
    public function testAddFindActionDefinition()
    {
        $actionDefinition = new ActionDefinition('dance');
        $this->manager->addActionDefinition($actionDefinition);
        
        $foundActionDefinition = $this->manager->findActionDefinitionByName('dance');
        $this->assertNotNull($foundActionDefinition);
        $this->assertEquals('dance', $foundActionDefinition->getName());
    }

}
