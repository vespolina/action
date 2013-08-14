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