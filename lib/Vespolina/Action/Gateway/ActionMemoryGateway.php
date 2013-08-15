<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Gateway;

use Vespolina\Action\Gateway\ActionGatewayInterface;
use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;

class ActionMemoryGateway implements ActionGatewayInterface
{
    protected $actions;
    protected $definitions;

    public function __construct()
    {
        $this->actions = array();
        $this->definitinos = array();
    }

    public function findActionsByState($state, $subject = null)
    {
        $actions = array();

        foreach ($this->actions as $action) {
            if ($state == $action->getState()) {
                $actions[] = $action;
            }
        }

        return $actions;
    }

    public function findByName($name)
    {
        if (!array_key_exists($name, $this->definitions))
            return;
            
        return $this->definitions[$name];
    }
    
    public function findByEventName($eventName)
    {
        $definitions = array();
        
        return $definitions;
    }
    
    public function findByTopic($topic)
    {
        $definitions = array();
        foreach ($this->definitions as $definition) {
            if ($topic == $definition->getTopic()) {
                $definitions[] = $topic;
            }
        }
        
        return $definitions;
    }

    public function updateAction(ActionInterface $action)
    {
        $key = $action->getSubjectId();
        $this->actions[$key] = $action;
    }

    public function updateActionDefinition(ActionDefinitionInterface $actionDefinition)
    {
        $this->definitions[$actionDefinition->getName()] = $actionDefinition;
    }
}
