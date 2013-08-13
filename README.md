action
======

This library manages actions.  An action can hold anything, from a notification to a webservice call.
 * What sets actions apart from traditonal system events (event dispatcher concept) processing is the fact that
actions can be reprocessed or scheduled to be executed in the future (eg. one week later)

Additionally actions can be fully logged including the context they ran for audit purposes.  For instance when a company ID check is performed in Europe the result of the webservice call needs to be stored.


Actions are attached to subjects such as ecommerce orders.  An action manager can retrieve for a given subject (eg order) a trace of actions which have been performed and allow actions to be reprocessed.
If a customer did not receive an order confirmation mail the action linked to the confirmation can be triggered again.