action
======

This library manages actions.  An action can hold anything, from a notification to a webservice call.
Actions are typically raised from a system event on a subject (eg. sales order raises a "confirmed" event).

What sets actions apart from traditonal event processing is the fact that
actions can be reprocessed and/or scheduled to be executed in the future (eg. one week later).  The scheduling and outcome for a particular action are also persisted to a gateway (eg. Mongodb, ORM, ...)

Additionally actions can be fully logged including the context they ran with for audit purposes.  
For instance when a company ID check is performed in Europe the result of the webservice call needs to be stored.

Actions are attached to subjects such as ecommerce orders.  An action manager can retrieve for a given subject (eg order) a trace of actions which have been performed and allow actions to be reprocessed.
If a customer did not receive an order confirmation mail the action linked to the confirmation can be triggered again.

Examples
=======

In memory action manager:

```php
 $actionManager = new ActionManager(new ActionDefinitionMemoryGateway(), new EventDispatcher());

//Register two action definitions
$actionDefinition1 = new ActionDefinition('car', 'cleanTheCar');
$actionDefinition2 = new ActionDefinition('car', 'fuelTheCar');
$actionManager->addActionDefinition($actionDefinition1);
$actionManager->addActionDefinition($actionDefinition2);

//Link the event to one or multiple action definitions
$actionManager->linkEvent('car_event.state.sold', array($actionDefinition1, $actionDefinition2));

//Initiate processing of an event
$actionManager->processEvent('cart_event.state.sold', new Event($myCar));
```

The outcome of the processing is:
* Two Action instance are created, one with the name 'cleanTheCar' and one 'fuelTheCar'
* The two actions are directly executed.  The outcome of the executing is registered
* Te two action instances are persisted to the peristence gateway (in memory in this example)
* While persisting the outcome of the actions are saved as well.

Suppose that it wasn't possible to fuel the car because no gasoline could be found at the time
We can detect failed actions and reprocess them (if allowed by the action definition)

```php
$failedActions = $actionManager->findActionsByState($myCar, Actions::FAILED);

foreach ($failedActions as $action) {
    $actionManager->reprocess($action);
}
```
The action managers logs new attempt to reprocess and the outcome.


        
