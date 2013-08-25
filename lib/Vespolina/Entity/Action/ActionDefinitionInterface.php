<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\Entity\Action;

/**
 * An interface defining an action definition
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface ActionDefinitionInterface
{
    /**
     * Get the name of the action
     *
     * @return string
     */
    function getName();

    /**
     * Retrieve parameters which are injected into the action
     *
     * @return string
     */
    function getParameters();

    /**
     * Return the class name which will execute the action
     *
     * @return string
     */
    function getExecutionClass();

    /**
     * Return the class name which will handle the lifetime and behavior of an action
     *
     * @return string
     */
    function getHandlerClass();

    /**
     * Set the class name which will handle the lifetime and behavior of an action
     *
     * @param $handlerClass
     * @return mixed
     */
    function setHandlerClass($handlerClass);

    /**
     * Should the action directly be execute or scheduled for later
     *
     * @return mixed
     */
    function getSchedulingType();
    
    /**
     * Get the topic of the action definition (eg. order, cart)
     */
    function getTopic();

    /**
     * Are we even allowing the action to be reprocessed
     *
     * @return boolean
     */
    function isReprocessingAllowed();
}