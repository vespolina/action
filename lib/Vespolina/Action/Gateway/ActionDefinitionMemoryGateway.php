<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Gateway;

use Vespolina\Action\Gateway\ActionDefinitionGatewayInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;

class ActionDefinitionMemoryGateway implements ActionDefinitionGatewayInterface
{
    protected $definitions;

    public function __construct()
    {
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
    
    public function update(ActionDefinitionInterface $actionDefinition)
    {
        $this->definitions[$actionDefinition->getName()] = $actionDefinition;
    }
}
