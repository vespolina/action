<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Tests\Entity\Action\Manager;

use Vespolina\Entity\Action\Action;
use Vespolina\Entity\Action\ActionDefinition;

/**
 */
class ActionTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $subject = 'order-car-123';
        $context = array('color' => 'red');
        $action = new Action(new ActionDefinition('orderPaintForCar','Class'), 'orderPaintForCar', $subject, $context);
        $action->setState(Action::STATE_COMPLETED);
        $action->setExecutedAt(new \DateTime("now"));

        $this->assertEquals($action->getDefinition()->getName(), 'orderPaintForCar');
        $this->assertEquals($action->getName(), 'orderPaintForCar');
        $this->assertEquals($action->getContext(), $context);
        $this->assertEquals($action->getSubject(), $subject);   
    }

    public function testIsCompleted()
    {
        $subject = 'order-car-124';
        $context = array('color' => 'red');
        $action = new Action(new ActionDefinition('orderPaintForCar','Class'), 'orderPaintForCar', $subject, $context);
        $action->setState(Action::STATE_COMPLETED);

        $this->assertTrue($action->isCompleted());
    }
}
