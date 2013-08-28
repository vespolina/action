<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Tests\Action\Gateway;

use Vespolina\Action\Gateway\ActionMemoryGateway;

class ActionMemoryGatewayTest extends ActionGatewayTestCommon
{
    protected function setUp()
    {
        $this->actionGateway = new ActionMemoryGateway();
        parent::setUp();
    }
}