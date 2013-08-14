<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Manager;

use Vespolina\Entity\Action\ActionDefinitionInterface;
use Vespolina\Action\Gateway\ActionDefinitionGatewayInterface;

class ActionManager implements ActionManagerInterface
{
    protected $eventDispatcher;
    protected $definitionGateway;
    protected $actionGenerators;

    public function __construct(ActionDefinitionGatewayInterface $definitionGateway, $eventDispatcher)
    {
        $this->actionGenerators = array();
        $this->definitionGateway = $definitionGateway;
        $this->eventDispatcher = $eventDispatcher;
        
    }

    public function createAction($actionDefinitionName)
    {
        $actionDefinition = $this->definitionGateway->findByName($actionDefinitionName);
        
        if (null == $actionDefinition) {
            //Todo throw error
        }
        
        //$action = new $actionDefinition->getClassHandlerName();
        
        return $action;
    }
    
    public function addActionDefinition(ActionDefinitionInterface $actionDefinition)
    {
        $this->definitionGateway->update($actionDefinition);
    }
    
    public function addActionGenerator(ActionGeneratorInterface $actionGenerator)
    {
        $this->actionGenerators[] = $actionGenerator;
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
}
