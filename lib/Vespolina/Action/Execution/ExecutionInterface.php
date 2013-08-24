<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\Action\Execution;

use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;

/**
 * An interface to (re)execute an action
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface ExecutionInterface
{
    /**
     * Execute an action
     *
     * @param ActionInterface $action
     */
    function execute(ActionInterface $action);
}