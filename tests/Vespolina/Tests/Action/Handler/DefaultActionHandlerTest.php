<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\Action\Tests\Generator;

use Vespolina\Action\Handler\DefaultActionHandler;
use Vespolina\Entity\Action\ActionDefinition;

/**
 */
class DefaultActionHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateAction()
    {
        $executors = array();
        $handler = new DefaultActionHandler('Vespolina\Entity\Action\Action', $executors);
        $actionDefinition = new ActionDefinition('test', 'ExecutionClass');
        $action = $handler->createAction($actionDefinition);
        $this->assertInstanceOf('Vespolina\Entity\Action\Action', $action);         
    }
}
