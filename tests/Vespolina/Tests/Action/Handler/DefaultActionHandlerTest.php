<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Tests\Action\Generator;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Vespolina\Action\Event\ActionEvent;
use Vespolina\Action\Handler\DefaultActionHandler;
use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Entity\Action\Action;

class DefaultActionHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $dispatcher;
    protected $handler;

    protected function setUp()
    {
        $this->dispatcher = new EventDispatcher();
        $this->handler = new DefaultActionHandler('Vespolina\Entity\Action\Action', $this->dispatcher);
    }

    public function testCreateAction()
    {
        $actionDefinition = new ActionDefinition('test', 'v.test');
        $parameters = array('par1' => 'val1', 'par2' => 'val2');
        $actionDefinition->setParameters($parameters);
        $action = $this->handler->createAction($actionDefinition);

        $this->assertInstanceOf('Vespolina\Entity\Action\Action', $action);

        //Assert that parameters where correctly copied to the context
        $context = $action->getContext();
        foreach ($parameters as $key => $value) {
            $contextValue = $context[$key];
            $this->assertEquals($contextValue, $value);
        }
    }

    public function testExecutionActionWithSuccess()
    {
        $actionDefinition = new ActionDefinition('action1');
        $actionDefinition->setEventName('v.action.action1.execute');
        $action = $this->handler->createAction($actionDefinition);

        //Register our action listener
        $this->dispatcher->addListener('v.action.action1.execute', array(new MyGoodActionEventListener(), 'onExecute'));

        //Fire ahoy!
        $this->handler->process($action, $actionDefinition);

        //Event dispatcher should have called the event listener, so let's have a look at the outcome
        $this->assertTrue($action->isCompleted());
    }

    public function testExecutionActionWithFailure()
    {
        $actionDefinition = new ActionDefinition('action2');
        $action = $this->handler->createAction($actionDefinition);

        //Register our action listener
        $this->dispatcher->addListener('v.action.action2.execute', array(new MyBadActionEventListener(), 'onExecute'));

        $this->handler->process($action, $actionDefinition);

        //Event dispatcher should have called the event listener, so let's have a look at the outcome
        $this->assertEquals(Action::STATE_FAILURE, $action->getState());
    }

    public function testExecutionActionRestart()
    {
        $actionDefinition = new ActionDefinition('action3');
        $action = $this->handler->createAction($actionDefinition);

        //Register our action listener
        $this->dispatcher->addListener('v.action.action3.execute', array(new MyBadAndGoodActionEventListener(), 'onExecute'));

        //First time the processing would fail
        $this->handler->process($action, $actionDefinition);
        $this->assertEquals(Action::STATE_FAILURE, $action->getState(), 'First time the action should fail');

        //Second time the execution should succeed
        $this->handler->process($action, $actionDefinition);
        $this->assertTrue($action->isCompleted(), 'Second time the action should succeed');

    }
}


class MyGoodActionEventListener
{
    function onExecute(ActionEvent $event)
    {
        $event->getAction()->setState(Action::STATE_COMPLETED);
    }
}

class MyBadActionEventListener
{
    function onExecute(ActionEvent $event)
    {
        $event->getAction()->setState(Action::STATE_FAILURE);
    }
}

class MyBadAndGoodActionEventListener
{
    protected $evil = true;

    function onExecute(ActionEvent $event)
    {
        if (true == $this->evil) {

            $this->evil = false;
            $event->getAction()->setState(Action::STATE_FAILURE);
        } else {
            $event->getAction()->setState(Action::STATE_COMPLETED);
        }
    }
}
