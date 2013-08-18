<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Manager;

use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;
use Vespolina\Action\Gateway\ActionGatewayInterface;
use Vespolina\Action\Handler\DefaultActionHandler;

class ActionManager implements ActionManagerInterface
{
    protected $actionClass;
    protected $actionDefinitionClass;
    
    protected $handlers;
    protected $eventDispatcher;
    protected $definitionGateway;
    protected $generators;

    public function __construct(ActionGatewayInterface $definitionGateway, $eventDispatcher, 
                                $actionClass = 'Vespolina\Entity\Action\Action',
                                $actionDefinitionClass = 'Vespolina\Entity\Action\ActionDefinition')
    {
        $this->actionClass = $actionClass;
        $this->actionDefinitionClass = $actionDefinitionClass;
        
        $this->eventDispatcher = $eventDispatcher;
        $this->definitionGateway = $definitionGateway;
        $this->generators = array();
        $this->handlers = array();
        
        //Register the default handler
        $this->handlers['Vespolina\Action\Handler\DefaultActionHandler'] = new DefaultActionHandler($this->actionClass);
    }

    public function createAction($actionDefinitionName, $subject = null)
    {
        $actionDefinition = $this->definitionGateway->findDefinitionByName($actionDefinitionName);
        $action = null;

        if (null == $actionDefinition) {
            //Todo throw error
        }
        
        return $this->handlers[$actionDefinition->getHandlerClass()]->createAction($actionDefinition);
    }
    
    public function addActionDefinition(ActionDefinitionInterface $actionDefinition)
    {
        $this->definitionGateway->updateActionDefinition($actionDefinition);
    }
    
    public function addActionGenerator(ActionGeneratorInterface $actionGenerator)
    {
        $this->generators[] = $actionGenerator;
    }
    
    public function findActionDefinitionByName($name)
    {
        return $this->definitionGateway->findDefinitionByName($name);
    }
    
    public function handleEvent($eventName, $event)
    {
        foreach ($this->actionGenerators as $generator) 
        {
            $actions = $generator->handle($eventName, $event);
        }
    }
    
    public function linkEvent($event, array $actionDefinitions) 
    {
        //TODO
    }

    public function process(ActionInterface $action)
    {
        return $this->doProcess($action, false);
    }

    public function reprocess(ActionInterface $action)
    {
        return $this->doProcess($action, true);
    }

    protected function doProcess(ActionInterface $action, $reprocess = false)
    {
        //The first question is, are we even allowed to reprocess this action?
        $definition = $this->findActionDefinitionByName($action->getName());
        
        if (null == $definition) {
            //TODO: Throw an error
        }

        $handler = $this->handlers[$definition->getHandlerClass()];

        if ($reprocess) {
            //Delegate to the action handler to see if the action is reprocessable
            $isReprocessable = $handler->isReprocessable($action, $definition);

            if (false == $isReprocessable) {
                //TODO: Throw an error
            }

        }

        //Cool, we can process the action!
        return $handler->process($action, $definition);
    }
}
