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
     * @return string
     */
    function getName();
    
    function getParameters();

    /**
     * Return the class name which will execute the action
     * @return string
     */
    function getExecutionClass();

    function getHandlerClass();

    function setHandlerClass($handlerClass);
    
    function getSchedulingType();
    
    /**
     * Get the topic of the action definition (eg. order, cart)
     */
    function getTopic();
    
    function isReprocessingAllowed();
}