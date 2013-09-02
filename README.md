action
======

## Introduction

This library manages actions.  An action can hold anything, from a notification to a webservice call.
Actions are typically raised from a system event on a subject (eg. sales order raises a "confirmed" event).

What sets actions apart from traditional event processing is the fact that
actions can be reprocessed and/or scheduled to be executed in the future (eg. one week later).  The scheduling and outcome for a particular action are also persisted to a gateway (eg. Mongodb, ORM, ...)

Additionally actions can be fully logged including the context they ran with for audit purposes.  
For instance when a company ID check is performed in Europe the result of the webservice call needs to be stored.

Actions are attached to subjects such as ecommerce orders.  An action manager can retrieve for a given subject (eg order) a trace of actions which have been performed and allow actions to be reprocessed.
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
* The outcome of the processing is persisted to the persistence gateway (in memory in this example)
*
Suppose that it wasn't possible to fuel the car because no gasoline could be found.  The action would definitely fail.
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
* execution class : Name of the execution class to actually *do* something
* handler class : Name of the class which handles the overall behavior and lifetime of an action
* scheduling type : Should the action be executed directly or scheduled in the future?
* parameters : An array of parameters which are injected to a newly created action which the action needs during processing
$ isReprocessingAllowed:  Are we allowing an action to be reprocessed anyhow?


## Gateway support

Currently we support following action gateways

* Memory gateway
* Doctrine MongoDB gateway


## Todo

* Use event dispatcher to dispatch action lifecycle events
* Write an ORM gateway