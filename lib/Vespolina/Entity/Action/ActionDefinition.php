<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Entity\Action;

class ActionDefinition implements ActionDefinitionInterface
{
    protected $executionClass;
    protected $handlerClass;
    protected $name;
    protected $parameters;
    protected $schedulingType;
    protected $topic;
    
    public function __construct($name, $executionClass, $topic = 'default')
    {
        $this->executionClass = $executionClass;
        $this->handlerClass = 'Vespolina\Action\Handler\DefaultActionHandler';
        $this->name = $name;
        $this->topic = $topic;
    }

    public function getExecutionClass()
    {
        return $this->executionClass;
    }

    public function getHandlerClass()
    {
        return $this->handlerClass;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }

    public function getSchedulingType()
    {
        return $this->schedulingType;
    }
    
    public function getTopic()
    {
        return $this->topic;
    }

    public function setHandlerClass($handlerClass)
    {
        $this->handlerClass = $handlerClass;
    }

    public function isReprocessingAllowed()
    {
        return true;
    }
}
