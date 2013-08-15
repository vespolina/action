<?php

namespace Vespolina\Action\Tests\Gateway;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Vespolina\Action\Gateway\ActionMemoryGateway;
use Vespolina\Entity\Action\ActionDefinition;

/**
 */
class ActionManagerMemoryGatewayTest extends \PHPUnit_Framework_TestCase
{

    public function testAddAndFind()
    {
        $gateway = $this->getGateway();
        
        $actionDefinition = new ActionDefinition('callForHelp');
        $gateway->updateActionDefinition($actionDefinition);
        
        $retrievedActionDefinition = $gateway->findByName('callForHelp');
        $this->assertNotNull($retrievedActionDefinition);
        $this->assertEquals('callForHelp', $retrievedActionDefinition->getName());
        
    }
    
    protected function getGateway()
    {        
        return new ActionMemoryGateway();
    }
}
