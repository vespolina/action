<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Tests\Action\Manager;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Vespolina\Action\Event\ActionEvent;
use Vespolina\Action\Manager\ActionManager;
use Vespolina\Action\Gateway\ActionMemoryGateway;
use Vespolina\Entity\Action\Action;
use Vespolina\Entity\Action\ActionDefinition;



/**
 */
class ActionManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $manager;
    protected $dispatcher;

    protected function setUp()
    {
        $this->dispatcher = new EventDispatcher();
        $this->manager = new ActionManager(new ActionMemoryGateway(), $this->dispatcher);
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
        $actionDefinition = new ActionDefinition('shake');
        $this->manager->addActionDefinition($actionDefinition);

        //Register our action listener
        $this->dispatcher->addListener('v.action.shake.execute', array(new DanceExecutionListener(), 'onExecute'));

        $action = $this->manager->launchAction('shake', new DummySubject());
    }
}

class DanceExecutionListener
{
    function onExecute(ActionEvent $event)
    {
        //Do something cool like dancing
        $event->getAction()->setState(Action::STATE_COMPLETED);
    }
}

class DummySubject
{

}
