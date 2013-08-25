<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Handler;

use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;

class DefaultActionHandler implements ActionHandlerInterface
{
    protected $actionClass;
    protected $executors;
    
    public function __construct($actionClass, &$executors)
    {
        $this->actionClass = $actionClass;
        $this->executors = $executors;
    }

    /**
     * @inheritdoc
     */
    public function createAction(ActionDefinitionInterface $actionDefinition)
    {
        return new $this->actionClass($actionDefinition->getName());
    }

    /**
     * @inheritdoc
     */
    public function isReprocessable(ActionInterface $action, ActionDefinitionInterface $definition)
    {
        //Here you could add additional logic based on the action definition and the current context of the action
        //But we only check the action definition here.
        return $definition->isReprocessable();
    }

    /**
     * @inheritdoc
     */
    public function process(ActionInterface $action, ActionDefinitionInterface $definition)
    {
       $executor = $this->getExecutor($definition);

       return $executor->execute($action);
    }

    /**
     * Retrieve an instance of the executor class if not yet already present in the cache
     *
     * @param ActionDefinitionInterface $definition
     * @return mixed
     */
    protected function getExecutor(ActionDefinitionInterface $definition)
    {
        $class = $definition->getExecutionClass();

        if (!array_key_exists($class, $this->executors)) {
            $this->executors[$class] = new $class();
        }

        return $this->executors[$class];
    }
}
