<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Action\Tests\Manager;

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
        $actionDefinition = new ActionDefinition('dance', 'DanceExecutionClass');
        $this->manager->addActionDefinition($actionDefinition);
        
        $foundActionDefinition = $this->manager->findActionDefinitionByName('dance');
        $this->assertNotNull($foundActionDefinition);
        $this->assertEquals('dance', $foundActionDefinition->getName());
    }

    public function testCreateAction()
    {
        $actionDefinition = new ActionDefinition('shake', 'DanceExecutionClass');
        $this->manager->addActionDefinition($actionDefinition);
        $action = $this->manager->createAction('shake', 'dog007');

        $this->assertInstanceOf('Vespolina\Entity\Action\Action', $action);
    }

    public function testCreateAndExecuteAction()
    {
        $actionDefinition = new ActionDefinition('shake', 'DanceExecutionClass');
        $this->manager->addActionDefinition($actionDefinition);
        $action = $this->manager->createAndExecuteAction('shake', 'dog007');

    }

}

class DanceExecutionClass implements  ExecutionInterface
{
    /**
     * Execute an action
     *
     * @param ActionInterface $action
     */
    function execute(ActionInterface $action)
    {
        //Do something cool like dancing
        $action->setState(Action::STATE_COMPLETED);
    }

}
