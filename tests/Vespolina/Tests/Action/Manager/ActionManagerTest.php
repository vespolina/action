<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Tests\Action\Manager;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Vespolina\Action\Execution\ExecutionInterface;
use Vespolina\Action\Manager\ActionManager;
use Vespolina\Action\Gateway\ActionMemoryGateway;
use Vespolina\Entity\Action\Action;
use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Entity\Action\ActionInterface;


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
        $actionDefinition = new ActionDefinition('dance', 'Vespolina\Tests\Action\Manager\DanceExecutionClass');
        $this->manager->addActionDefinition($actionDefinition);
        
        $foundActionDefinition = $this->manager->findActionDefinitionByName('dance');
        $this->assertNotNull($foundActionDefinition);
        $this->assertEquals('dance', $foundActionDefinition->getName());
    }

    public function testCreateAction()
    {
        $actionDefinition = new ActionDefinition('shake', 'Vespolina\Tests\Action\Manager\DanceExecutionClass');
        $this->manager->addActionDefinition($actionDefinition);
        $action = $this->manager->createAction('shake', 'dog007');

        $this->assertInstanceOf('Vespolina\Entity\Action\Action', $action);
    }

    public function testLaunchAction()
    {
        $actionDefinition = new ActionDefinition('shake',  'Vespolina\Tests\Action\Manager\DanceExecutionClass');
        $this->manager->addActionDefinition($actionDefinition);
        $action = $this->manager->launchAction('shake', new DummySubject());
    }
}

class DanceExecutionListener
{
    function execute(ActionEvent $event)
    {
        //Do something cool like dancing
        $event->getAction()->setState(Action::STATE_COMPLETED);
    }

}

class DummySubject
{

}
