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
use Vespolina\Action\Execution\ExecutionInterface;
use Vespolina\Action\Gateway\ActionGatewayInterface;
use Vespolina\Action\Generator\ActionGeneratorInterface;
use Vespolina\Action\Handler\DefaultActionHandler;
use Vespolina\Action\Generator\DefaultActionGenerator;

class ActionManager implements ActionManagerInterface
{
    protected $actionClass;
    protected $actionDefinitionClass;
    protected $eventMap;
    protected $handlers;
    protected $eventDispatcher;
    protected $actionGateway;
    protected $generators;

    public function __construct(ActionGatewayInterface $actionGateway, $eventDispatcher, 
                                $actionClass = 'Vespolina\Entity\Action\Action',
                                $actionDefinitionClass = 'Vespolina\Entity\Action\ActionDefinition')
    {
        $this->actionClass = $actionClass;
        $this->actionDefinitionClass = $actionDefinitionClass;
        $this->eventDispatcher = $eventDispatcher;
        $this->eventMap = array();
        $this->actionGateway = $actionGateway;
        $this->handlers = array();
        
        //Register a default handler
        $this->handlers['Vespolina\Action\Handler\DefaultActionHandler'] = new DefaultActionHandler($this->actionClass, $this->eventDispatcher);
    }

    /**
     * {@inheritDoc}
     */
    public function createAction($actionDefinitionName, $subject = null)
    {
        $actionDefinition = $this->actionGateway->findDefinitionByName($actionDefinitionName);
        $action = null;

        if (null == $actionDefinition) {
            //Todo throw error
        }
        
        return $this->handlers[$actionDefinition->getHandlerClass()]->createAction($actionDefinition, $subject);
    }

    /**
     * {@inheritDoc}
     */
    public function launchAction($actionDefinitionName, $subject = null)
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
        $this->actionGateway->updateActionDefinition($actionDefinition);
    }

    /**
     * {@inheritDoc}
     */
    public function findActionDefinitionByName($name)
    {
        return $this->actionGateway->findDefinitionByName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function findActionDefinitionsForEvent($eventName)
    {
        if (array_key_exists($eventName, $this->eventMap)) {

            return $this->eventMap[$eventName];
        }
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
     */
    protected function doExecute(ActionInterface $action, $reprocess = false)
    {
        //The first question is, are we even allowed to reprocess this action?
        $definition = $this->findActionDefinitionByName($action->getName());
        
        if (null == $definition) {
            throw new \RuntimeException(sprintf('Could not load action definition for action %a', $action->getName()));
        }

        $handler = $this->handlers[$definition->getHandlerClass()];

        if ($reprocess) {
            //Delegate to the action handler to see if the action is reprocessable
            $isReprocessable = $handler->isReprocessable($action, $definition);

            if (false == $isReprocessable) {
                throw new \RuntimeException(sprintf('Reprocessing is not allowed for action %a', $action->getName()));
            }
        }

        //Cool, we can process the action!
        $handler->process($action, $definition);
        
        //Save the state of the action
        $this->actionGateway->updateAction($action);
    }
}
