<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Handler;

use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;
use Vespolina\Action\Handler\ActionHandlerInterface;

class DefaultActionHandler implements ActionHandlerInterface
{
    protected $actionClass;
    
    public function __construct($actionClass)
    {
        $this->actionClass = $actionClass;
    }
    
    public function createAction(ActionDefinitionInterface $actionDefinition)
    {
        return new $this->actionClass($actionDefinition->getName());
    }

    public function isReprocessable(ActionInterface $action, ActionDefinitionInterface $definition)
    {
        //Here you want to add additional logic based on the action definition and the current context of the action
        //But we only check the action definition here.
        return $definition->isReprocessable();
    }
}
