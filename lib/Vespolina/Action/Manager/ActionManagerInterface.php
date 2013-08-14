<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Manager;

use Vespolina\Entity\Action\ActionDefinitionInterface;

/**
 * An interface to manage actions
 *
 * @author Daniel Kucharski <daniel-xerias.be>
 */
interface ActionManagerInterface
{
    /** Create an action by it's name */
    function createAction($name);
     
    function addActionDefinition(ActionDefinitionInterface $actionDefinition);
    
    function handleEvent($eventName, $event);
    
    function linkEvent($event, array $actionDefinitions);
}

