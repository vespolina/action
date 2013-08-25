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
use Vespolina\Action\Generator\ActionGeneratorInterface;
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
        
        //Register a default handler
        $this->handlers['Vespolina\Action\Handler\DefaultActionHandler'] = new DefaultActionHandler($this->actionClass);
    }

    /**
     * {@inheritDoc}
     */
    public function createAction($actionDefinitionName, $subject = null)
    {
        $actionDefinition = $this->definitionGateway->findDefinitionByName($actionDefinitionName);
        $action = null;

        if (null == $actionDefinition) {
            //Todo throw error
        }
        
        return $this->handlers[$actionDefinition->getHandlerClass()]->createAction($actionDefinition);
    }

    /**
     * {@inheritDoc}
     */
    public function createAndExecuteAction($actionDefinitionName, $subject = null)
    {
        $action = $this->createAction($actionDefinitionName, $subject);

        if (null != $action) {
            $this->execute($action);
        }

        return $action;
    }

    /**
     * {@inheritDoc}
     */
    public function addActionDefinition(ActionDefinitionInterface $actionDefinition)
    {
        $this->definitionGateway->updateActionDefinition($actionDefinition);
    }

    /**
     * {@inheritDoc}
     */
    public function addActionGenerator(ActionGeneratorInterface $actionGenerator)
    {
        $this->generators[] = $actionGenerator;
    }

    /**
     * {@inheritDoc}
     */
    public function findActionDefinitionByName($name)
    {
        return $this->definitionGateway->findDefinitionByName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function handleEvent($eventName, $event)
    {
        foreach ($this->actionGenerators as $generator) 
        {
            $actions = $generator->handle($eventName, $event);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function linkEvent($event, array $actionDefinitions) 
    {
        
        //TODO
    }

    /**
     * {@inheritDoc}
     */
    public function execute(ActionInterface $action)
    {
        return $this->doExecute($action, false);
    }

    /**
     * {@inheritDoc}
     */
    public function reprocess(ActionInterface $action)
    {
        return $this->doExecute($action, true);
    }

    /**
     * Start the execution of an action or schedule the action for processing later on
     *
     * @param ActionInterface $action
     * @param bool $reprocess
     * @return mixed
     */
    protected function doExecute(ActionInterface $action, $reprocess = false)
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
