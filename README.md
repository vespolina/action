action
======

[![Build Status](https://secure.travis-ci.org/vespolina/action.png?branch=master)](http://travis-ci.org/vespolina/action)
[![Total Downloads](https://poser.pugx.org/vespolina/action/downloads.png)](https://packagist.org/packages/vespolina/action)
[![Latest Stable Version](https://poser.pugx.org/vespolina/action/v/stable.png)](https://packagist.org/packages/vespolina/action)

## Introduction

This library manages the lifecycle of actions.  An action is something to be executed at a given time.  This might be direct or scheduled to be executed in the future.
The action keeps track of the outcome of the execution and saves the state of the execution into a persistence layer.
Examples of typical things you would want to be contained in an action are notifications, sending letters by mail to customers, performing webservice calls, ..
Actions are typically raised from system events on a subject (eg. sales order raises a "confirmed" event).

What sets actions further apart from traditional event processing is the fact that actions can be reprocessed and rescheduled (eg. to be executed one week later).
When an order has been fulfilled, an action could be scheduled to send the customer a welcome pack one week after he has paid for the order.

Additionally actions can be fully logged including the context they ran with for audit purposes.  
For instance when a company ID check is performed in Europe the result of the webservice call needs to be stored by legal requirements.

n action manager can retrieve for a given subject (eg order) a trace of actions which have been performed and allow actions to be reprocessed.
If a customer did not receive an order confirmation mail the action linked to the confirmation can be triggered again.

## Examples

In memory action manager:

```php
$dispatcher = new EventDispatcher();

$actionManager = new ActionManager(new ActionDefinitionMemoryGateway(), $dispatcher);

//Register two action definitions
$actionDefinition1 = new ActionDefinition('cleanTheCar', 'car');
$actionDefinition2 = new ActionDefinition('fuelTheCar', 'car');
$actionManager->addActionDefinition($actionDefinition1);
$actionManager->addActionDefinition($actionDefinition2);

//Create two action event listeners

public class CleanTheCar
{
    function onExecute(ActionEvent $event) {
        //Clean the car
        $event->getAction()->setState(Action::STATE_COMPLETED);
    }
}

public class FuelTheCar
{
    function onExecute(ActionEvent $event) {
        //Check for gasoline for subject $action->getSubject();
        if ($gasolineAvailable) {
            //Fuel the car
            $event->getAction()->setState(Action::STATE_COMPLETED);
        } else {
            $event->getAction()->setState(Action::STATE_FAILED);
        }
    }
}

//Register the events to the dispatcher
$dispatcher->addListener('v.action.cleanTheCar.execute', array(new CleanTheCar(), 'onExecute'));
$dispatcher->addListener('v.action.fuelTheCar.execute', array(new FuelTheCar(), 'onExecute'));

//Launch an action
$actionManager->launchAction('cleanTheCar', new Porsche(911));

```
The outcome of the processing is:
* An Action instance is created to keep track of the processing
* In our simple example the action can be directly execute
* The outcome of the processing is persisted to the persistence gateway (in memory in this example, but typically it will be a database)
* Suppose that it wasn't possible to fuel the car because no gasoline could be found.  The action would definitely fail.
Typically somebody would be notified and the action would be performed again later.

We can detect failed actions and reprocess them (if allowed by the action definition)

```php
$failedActions = $actionManager->findActionsByState(Actions::FAILED, $myCar);

foreach ($failedActions as $action) {
    $actionManager->execute($action);
}
```
The action managers logs new attempt to reprocess again.

## Action definition

An action definition holds following information

* name : Name of the action definition, should be unique
* topic : Optionally you can define the topic of the action. Eg. "order", "customer"
* event name : Name of the event which is dispatched when the action is to be executed
* handler class : Name of the class which handles the overall behavior and lifetime of an action
* scheduling type : Should the action be executed directly or scheduled in the future?
* parameters : An array of parameters which are injected to a newly created action which the action needs during processing.
Eg. if the action is a mail notification, the template name could be a parameter
$ isReprocessingAllowed:  Are we allowing an action to be reprocessed anyhow?


## Gateway support

Currently we support following action gateways

* Memory gateway
* Doctrine MongoDB gateway


## Todo

* Use event dispatcher to dispatch action lifecycle events
* Write an ORM gateway