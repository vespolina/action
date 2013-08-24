<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Generator;

use Vespolina\Action\Manager\ActionManagerInterface;

class DefaultActionGenerator implements ActionGeneratorInterface
{
    protected $actionManager;

    public function __construct(ActionManagerInterface $actionManager)
    {
        $this->actionManager = $actionManager;
    }
    
    public function generate($eventName, $event)
    {
        return null;
    }
}
