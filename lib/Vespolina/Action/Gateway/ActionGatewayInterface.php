<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Gateway;

use Vespolina\Entity\Action\ActionDefinitionInterface;
use Vespolina\Entity\Action\ActionInterface;

/**
 * An interface to manage actions
 *
 * @author Daniel Kucharski <daniel-xerias.be>
 */
interface ActionGatewayInterface
{
    /**
     * Find actions by state and optional the subject
     * @param $state
     * @param null $subject
     * @return mixed
     */
    function findActionsByState($state, $subject = null);

    /**
     * Find action definitions matching the event name (or pattern)
     */
    function findByEventName($eventName);
    
    /**
     * Find action by their topic (eg. find all actions for an order)
     */
    function findByTopic($topic);
    
    /**
     * Find action definition by name
     */    
    function findDefinitionByName($name);

    /**
     * Create or update the action to the persistence layer
     */
    function updateAction(ActionInterface $action);

    /**
     * Create or update the action definition to the persistence layer
     */
    function updateActionDefinition(ActionDefinitionInterface $actionDefinition);
}

