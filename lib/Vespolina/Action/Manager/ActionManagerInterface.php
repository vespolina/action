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
     * Create an action using the action definition name
     * and directly execute (or schedule it)
     *
     * @param $actionDefinitionName
     * @param null $subject
     * @return Vespolina\Entity\Action\ActionInterface
     */
    function createAndExecuteAction($actionDefinitionName, $subject = null);

    /**
     * Add a new action definition
     *
     * @param ActionDefinitionInterface $actionDefinition
     */
    function addActionDefinition(ActionDefinitionInterface $actionDefinition);

    /**
     * Register an action execution class
     *
     * @param ExecutionInterface $actionExecution
     * @return mixed
     */
    function addActionExecution(ExecutionInterface $actionExecution);
    /**
     * Add an action generator
     *
     * @param ActionGeneratorInterface $generator
     */
    function addActionGenerator(ActionGeneratorInterface $generator);

    /**
     * Retrieve an action definition by it's name
     * @param $name
     * @return Vespolina\Entity\Action\ActionDefinitionInterface
     */
    function findActionDefinitionByName($name);

    /**
     * Handle an inbound event, generate the relevant actions and execute them
     *
     * @param $eventName
     * @param $event
     * @return mixed
     */
    function handleEvent($eventName, $event);

    /**
     * Link an event name to one or multiple action definitions
     *
     * @param $event
     * @param array $actionDefinitions
     * @return mixed
     */
    function linkEvent($event, array $actionDefinitions);

    /**
     * Execute the given action
     *
     * @param ActionInterface $action
     * @return mixed
     */
    function execute(ActionInterface $action);

}

