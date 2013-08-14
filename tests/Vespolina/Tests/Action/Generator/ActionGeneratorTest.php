<?php

namespace Vespolina\Action\Tests\Generator;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Action\Generator\DefaultActionGenerator;
use Vespolina\Action\Gateway\ActionDefinitionMemoryGateway;
use Vespolina\Action\Manager\ActionManager;


/**
 */
class ActionGeneratorTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerateOneAction()
    {
        $actionManager = $this->getActionManager();    
        
        //Register two action definitions
        $actionDefinition1 = new ActionDefinition('car', 'cleanTheCar');
        $actionDefinition2 = new ActionDefinition('car', 'fuelTheCar');
        $actionManager->addActionDefinition($actionDefinition1);
        $actionManager->addActionDefinition($actionDefinition2);
        
        //Link the event to one or multiple action definitions
        $actionManager->linkEvent('car_event.state.sold', array($actionDefinition1, $actionDefinition2));
        
        $generator = new DefaultActionGenerator($actionManager);
        
        $colorMyCarEvent = new GenericEvent();
        $outcome = $generator->generate('car_event.state.sold', $colorMyCarEvent);
         
    }
    
    protected function getActionManager()
    {        
        return new ActionManager(new ActionDefinitionMemoryGateway(), new EventDispatcher());
    }
}
