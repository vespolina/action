<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Manager;

use Vespolina\Action\Execution\ExecutionInterface;
use Vespolina\Action\Generator\ActionGeneratorInterface;
use Vespolina\CommerceBundle\Action\ActionExecution;
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
     * Create an action entity for the action definition name
     * Optionally pass the subject (eg. order, cart, ...)
     *
     * @param $name
     * @param $subject
     *
     * @return Vespolina\Entity\Action\ActionInterface
     */
    function createAction($actionDefinitionName, $subject = null);

    /**
     * Launch an action using the action definition name
     *
     * @param $actionDefinitionName
     * @param null $subject
     * @return Vespolina\Entity\Action\ActionInterface
     */
    function launchAction($actionDefinitionName, $subject = null);

    /**
     * Add a new action definition
     *
     * @param ActionDefinitionInterface $actionDefinition
     */
    function addActionDefinition(ActionDefinitionInterface $actionDefinition);

    /**
     * Retrieve an action definition by it's name
     * @param $name
     * @return Vespolina\Entity\Action\ActionDefinitionInterface
     */
    function findActionDefinitionByName($name);

    /**
     * Retrieves a collection of action definitions linked to a particular event
     * @param $eventName string
     * @return array
     */
    function findActionDefinitionsForEvent($eventName);

    /**
     * Execute the given action
     *
     * @param ActionInterface $action
     * @return mixed
     */
    function execute(ActionInterface $action);
}

