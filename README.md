Action
======

## Introduction

This library manages actions.  An action can hold anything, from a notification to a webservice call.
Actions are typically raised from a system event on a subject (eg. sales order raises a "confirmed" event).

What sets actions apart from traditional event processing is the fact that
actions can be reprocessed and/or scheduled to be executed in the future (eg. one week later).
The scheduling and outcome for a particular action are also persisted to a gateway (eg. Mongodb, ORM, etc).

Additionally actions can be fully logged including the context they ran with for audit purposes.
For instance when a company ID check is performed in Europe the result of the webservice call needs to be stored.

Actions are attached to subjects such as ecommerce orders.  An action manager can retrieve for a given subject
(e.g. an order) a trace of actions which have been performed and allow actions to be reprocessed.
If a customer did not receive an order confirmation mail the action linked to the confirmation can be triggered again.

## Examples

In memory action manager:

``` php
$actionManager = new ActionManager(new ActionDefinitionMemoryGateway(), new EventDispatcher());

//Register two action definitions
$actionDefinition1 = new ActionDefinition('cleanTheCar', 'CleanTheCar', 'car');
$actionDefinition2 = new ActionDefinition('cleanTheCar', 'FuelTheCar', 'car');
$actionManager->addActionDefinition($actionDefinition1);
$actionManager->addActionDefinition($actionDefinition2);

//Create an execution Handler implementing ExecutionInterface

public class CleanTheCar implements ExecutionInterface
{
    function execute(ActionInterface $action) {
        //Clean the car
        $action->setState(Action::STATE_COMPLETED);
    }
}

public class FuelTheCar implements ExecutionInterface
{
    function execute(ActionInterface $action) {
        //Check for gasoline for subject $action->getSubject();
        if ($gasolineAvailable) {
            //Fuel the car
            $action->setState(Action::STATE_COMPLETED);
        } else {
            $action->setState(Action::STATE_FAILED);
        }
    }
}

//Link an event to one or multiple action definitions
$actionManager->linkEvent('car_event.state.sold', array($actionDefinition1, $actionDefinition2));

//Initiate processing of an event
$actionManager->processEvent('cart_event.state.sold', new GenericEvent($myCar));
```

The outcome of the processing is:
* Two Action instance are created, one with the name 'cleanTheCar' and one 'fuelTheCar'
* The two actions are directly executed.  The outcome of the executing is registered
* Te two action instances are persisted to the persistence gateway (in memory in this example)
* While persisting the outcome of the actions are saved as well.

Suppose that it wasn't possible to fuel the car because no gasoline could be found at the time our action would fail.
We can detect failed actions and reprocess them (if allowed by the action definition)

``` php
$failedActions = $actionManager->findActionsByState(Actions::FAILED, $myCar);

foreach ($failedActions as $action) {
    $actionManager->reprocess($action);
}
```

The action managers logs new attempt to reprocess again.

You can also directly create an action and execute it

``` php
$actionManager->executeAction($action);
```

## Action definition

An action definition hold following information

* name : Name of the action definition, should be unique
* topic : Optionally you can define the topic of the action. Eg. "order", "customer"
* execution class : Name of the execution class to actually *do* something
* handler class : Name of the class which handles the overall behavior and lifetime of an action
* scheduling type : Should the action be executed directly or scheduled in the future?
* parameters : An array of parameters which are injected to a newly created action which the action needs during processing
$ isReprocessingAllowed:  Are we allowing an action to be reprocessed anyhow?
