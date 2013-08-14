<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Generator;

use Vespolina\Action\Handler\ActionHandlerInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;

class DefaultActionHandler implements ActionHandlerInterface
{
    protected $actionClass;

    public function __construct($actionClass = 'Vespolina\Event\Action\Action')
    {
        $this->actionClass = $actionClass;
    }
    
    public function createAction(ActionDefinitionInterface $actionDefinition)
    {
        $action = new $this->actionClass($actionDefinition->getName());
        
        return $action;
    }

}
