<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Action\Tests\Execution;

use Vespolina\Action\Execution\ExecutionInterface;
use Vespolina\Action\Handler\DefaultActionHandler;
use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\Action;

/**
 */
class ExecuteActionTest extends \PHPUnit_Framework_TestCase
{
    public function testExecutionActionWithSucces()
    {
        $action = $this->createAction();
        $actionExecution = new MyGoodActionExecution();
        $actionExecution->execute($action);

        $this->assertTrue($action->isCompleted($action));
    }

    public function testExecutionActionWithFailure()
    {
        $action = $this->createAction();
        $actionExecution = new MyBadActionExecution();
        $actionExecution->execute($action);

        $this->assertFalse($action->isCompleted($action));
    }

    public function testExecutionActionRestart()
    {
        $action = $this->createAction();
        $actionExecution = new MyBadAndGoodActionExecution();
        $actionExecution->execute($action);

        //First time the execution should fail
        $this->assertFalse($action->isCompleted($action));

        //Second time the execution should succeed
        $actionExecution->execute($action);
        $this->assertTrue($action->isCompleted($action));

    }

    protected function createAction()
    {
        $executors = array();
        $handler = new DefaultActionHandler('Vespolina\Entity\Action\Action', $executors);
        $actionDefinition = new ActionDefinition('test', 'ExecutionClass');

        return $handler->createAction($actionDefinition);
    }
}

class MyGoodActionExecution implements ExecutionInterface
{
    function execute(ActionInterface $action)
    {
        $action->setState(Action::STATE_COMPLETED);
    }
}

class MyBadActionExecution implements ExecutionInterface
{
    function execute(ActionInterface $action)
    {
        $action->setState(Action::STATE_FAILURE);
    }
}

class MyBadAndGoodActionExecution implements ExecutionInterface
{
    protected $evil = true;

    function execute(ActionInterface $action)
    {
        if (true == $this->evil) {

           $this->evil = false;
           $action->setState(Action::STATE_FAILURE);
        } else {
            $action->setState(Action::STATE_COMPLETED);
        }
    }
}