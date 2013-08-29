<?php

namespace spec\Vespolina\Action\Gateway;

use PhpSpec\ObjectBehavior;

class ActionMemoryGatewaySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Vespolina\Action\Gateway\ActionMemoryGateway');
        $this->shouldImplement('Vespolina\Action\Gateway\ActionGatewayInterface');
    }

    function it_does_not_find_definition_by_name()
    {
        $this->findDefinitionByName('fly')->shouldBeNull();
    }

    /**
     * @param \Vespolina\Entity\Action\ActionDefinitionInterface $actionDefinition
     */
    function it_does_find_definition_by_name_when_added($actionDefinition)
    {
        $actionDefinition->getName()->willReturn('fly');
        $this->updateActionDefinition($actionDefinition);
        $this->findDefinitionByName('fly')->shouldBeAnInstanceOf('Vespolina\Entity\Action\ActionDefinitionInterface');
    }


}