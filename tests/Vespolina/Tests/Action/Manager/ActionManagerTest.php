<?php

namespace Vespolina\Action\Tests\Manager;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Vespolina\Action\Manager\ActionManager;
use Vespolina\Action\Gateway\ActionDefinitionMemoryGateway;

/**
 */
class ActionManagerTest extends \PHPUnit_Framework_TestCase
{

    public function testAddActionDefinition()
    {
        $manager = $this->getActionManager();
    }
    
    

    
    protected function getActionManager()
    {        
        return new ActionManager(new ActionDefinitionMemoryGateway(), new EventDispatcher());
    }
}
