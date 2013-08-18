<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Generator;

/**
 * An interface that generates actions out of event dispatcher events
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface ActionGeneratorInterface
{
    function generate($eventName, $event);
}