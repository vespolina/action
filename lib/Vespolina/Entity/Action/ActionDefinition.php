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
    protected $eventName;
    protected $handlerClass;
    protected $name;
    protected $parameters;
    protected $schedulingType;
    protected $topic;
    protected $version;
    
    public function __construct($name, $topic = 'default')
    {
        $this->handlerClass = 'Vespolina\Action\Handler\DefaultActionHandler';
        $this->name = $name;
        $this->topic = $topic;
        $this->version = 1;
    }

    /**
     * {@inheritDoc}
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * {@inheritDoc}
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
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

    /**
     * {@inheritDoc}
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function isReprocessingAllowed()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion()
    {
        return $this->version;
    }


}
