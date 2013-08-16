<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Manager;

use Vespolina\Entity\Action\ActionDefinitionInterface;
use Vespolina\Entity\Action\ActionInterface;

/**
 * An interface to manage actions
 *
 * @author Daniel Kucharski <daniel-xerias.be>
 */
interface ActionManagerInterface
{
    /**
     * Create an action using the action definition name
     * Optionally pass the subject (eg. order, cart, ...)
     *
     * @param $name
     * @param $subject
     *
     * @return Vespolina\Entity\Action\ActionInterface
     */
    function createAction($actionDefinitionName, $subject = null);

    /**
     * Add a new action definition
     *
     * @param ActionDefinitionInterface $actionDefinition
     * @return mixed
     */
    function addActionDefinition(ActionDefinitionInterface $actionDefinition);

    function findActionDefinitionByname($name);
    /**
     * Handle an inbound event, generate the relevant actions and execute them
     *
     * @param $eventName
     * @param $event
     * @return mixed
     */
    function handleEvent($eventName, $event);

    /**
     * Link an event to one or multiple action definitions
     *
     * @param $event
     * @param array $actionDefinitions
     * @return mixed
     */
    function linkEvent($event, array $actionDefinitions);

    /**
     * Process the given action
     *
     * @param ActionInterface $action
     * @return mixed
     */
    function process(ActionInterface $action);

    /**
     * Process the given action again (on purpose!)
     *
     * @param ActionInterface $action
     * @return mixed
     */
    function reprocess(ActionInterface $action);
}

