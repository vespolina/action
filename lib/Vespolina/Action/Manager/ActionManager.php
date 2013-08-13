<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Manager;

class ActionManager implements ActionManagerInterface
{
    protected $eventDispatcher;
    protected $gateway;

    public function __construct($eventDispatcher)
    {
        if (!$eventDispatcher) {
            $eventDispatcher = new NullDispatcher();
        }

        $this->eventDispatcher = $eventDispatcher;
    }

    public function createAction($type)
    {

    }
}
