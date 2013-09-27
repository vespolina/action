<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Gateway;

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
        
        // If we have the subject, it is pretty easy to retrieve actions in a given state
        if (null != $subject) {
            if (array_key_exists($subject, $this->actions)) {
                foreach ($this->actions[$subject] as $action) {
                    if ($state == $action->getState()) {
                        $actions[] = $action;
                    }
                }
            }
            
            return $actions;
        }

        // If we have no subject, we need to iterate over all subjects *sigh*
        foreach ($this->actions as $subject => $subjectActions) {
            foreach ($subjectActions as $action) {
                if ($state == $action->getState()) {
                    $actions[] = $action;
                }
            }
        }

        return $actions;
    }

    public function findDefinitionByName($name)
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
        if (is_object($action->getSubject())) {
            $key = spl_object_hash($action->getSubject());
        } else {
            $key = $action->getSubject();
        }

        if (!array_key_exists($key, $this->actions)) {
            $this->actions[$key] = array();
        }

        $this->actions[$key][] = $action;
    }

    public function updateActionDefinition(ActionDefinitionInterface $actionDefinition)
    {
        $this->definitions[$actionDefinition->getName()] = $actionDefinition;
    }
