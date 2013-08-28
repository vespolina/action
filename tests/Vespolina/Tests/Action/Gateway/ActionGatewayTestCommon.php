<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Tests\Action\Gateway;

use Doctrine\ODM\MongoDB\Tests\Functional\Action;
use Vespolina\Entity\Action\ActionDefinition;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
abstract class ActionGatewayTestCommon extends \PHPUnit_Framework_TestCase
{
    protected $actionGateway;

    protected function setUp()
    {
    }


    public function testCreateAndFindActionDefinition()
    {
        $actionDefinitions = $this->createActionDefinitions();

        foreach ($actionDefinitions as $actionDefinition) {
            $this->actionGateway->updateActionDefinition($actionDefinition, false);
        }

        foreach ($actionDefinitions as $actionDefinition) {
            $actionDefinitionFound = $this->actionGateway->findDefinitionByName($actionDefinition->getName());
            //$this->assertNotNull($actionDefinitionFound);
        }
    }

    protected function createActionDefinitions()
    {
        $actionDefinition1 = new ActionDefinition('test1', 'ExecutionClass1','orderTopic1');
        $actionDefinition1->setParameters(array('p1' => 'v1', 'p2' => 'v2'));
        $actionDefinition2 = new ActionDefinition('test2', 'ExecutionClass2','orderTopic2');
        $actionDefinition2->setParameters(array('p1' => 'v1', 'p2' => 'v2'));

        return array ($actionDefinition1, $actionDefinition2);
    }
}