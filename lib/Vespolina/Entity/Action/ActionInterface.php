<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\Entity\Action;


/**
 * An interface defining an action.
 *
 * An action can hold anything, from a notification to a webservice call.
 * What sets action apart from system events (event dispatcher concept) is the fact that
 * they can be reprocessed or scheduled to be processed later on (eg. one week later)
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface ActionInterface
{
    function getName();

    function getSubject();

    function getContext();

    function setState($state);

    function setExecutedAt($executedAt);

    function setScheduledAt($scheduledAt);

}