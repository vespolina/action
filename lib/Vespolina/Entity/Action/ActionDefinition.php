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

    /**
     * {@inheritDoc}
     */
    public function getExecutionClass()
    {
        return $this->executionClass;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlerClass()
    {
        return $this->handlerClass;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function getSchedulingType()
    {
        return $this->schedulingType;
    }

    /**
     * {@inheritDoc}
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * {@inheritDoc}
     */
    public function setHandlerClass($handlerClass)
    {
        $this->handlerClass = $handlerClass;
    }

    public function isReprocessingAllowed()
    {
        return true;
    }
}
