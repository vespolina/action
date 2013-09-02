<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Handler;

use Vespolina\Action\Event\ActionEvent;
use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;

class DefaultActionHandler implements ActionHandlerInterface
{
    protected $actionClass;
    protected $eventDispatcher;
    
    public function __construct($actionClass, $eventDispatcher)
    {
        $this->actionClass = $actionClass;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @inheritdoc
     */
    public function createAction(ActionDefinitionInterface $definition, $subject = null)
    {
        //Initialize the context with the parameters from the action definition
        $context = array();
        $parameters = $definition->getParameters();
        if (null != $parameters) {
            $context = array_merge($context, $parameters);
        }

        return new $this->actionClass($definition, $definition->getName(), $subject, $context);
    }

    /**
     * @inheritdoc
     */
    public function isReprocessable(ActionInterface $action, ActionDefinitionInterface $definition)
    {
        //Here you could add additional logic based on the action definition and the current context of the action
        //But we only check the action definition here if it is ever allowed.
        return $definition->isReprocessable();
    }

    /**
     * @inheritdoc
     */
    public function process(ActionInterface $action, ActionDefinitionInterface $definition)
    {
       $event = new ActionEvent($action);
       $eventName = $definition->getEventName();

       if (null == $eventName) {
           $eventName = 'v.action.' . $action->getName() . 'execute';
       }
       $this->eventDispatcher->dispatch($eventName, $event);
    }
}
