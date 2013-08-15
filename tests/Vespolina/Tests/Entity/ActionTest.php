<?php

namespace Vespolina\Entity\Action\Tests\Manager;

use Vespolina\Action\Manager\ActionManager;
use Vespolina\Entity\Action\Action;

/**
 */
class ActionTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $subject = 'order-car-123';
        $context = array('color' => 'red');
        $action = new Action('orderPaintForCar', $subject, $context);
        $action->setState(Action::STATE_SUCCESS);
        $action->setExecutedAt(new \DateTime("now"));

        $this->assertEquals($action->getName(), 'orderPaintForCar');
        $this->assertEquals($action->getContext(), $context);
        $this->assertEquals($action->getSubject(), $subject);   
    }

}
