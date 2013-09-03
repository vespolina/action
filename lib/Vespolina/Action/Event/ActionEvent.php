<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Event;

use Symfony\Component\EventDispatcher\Event;
use Vespolina\Entity\Action\ActionInterface;

class ActionEvent extends Event
{
    protected $action;

    public function __construct(ActionInterface $action)
    {
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }
}