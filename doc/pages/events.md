Light events
=============
2019-11-06


Note: we use the [Light_Events](https://github.com/lingtalfi/Light_Events) service under the hood.


The Core/Light will dispatch the following events:


- Light.on_route_found: when a route matched. The argument is a [Light_Event](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Events/LightEvent.md) object which has a **route** variable containing the matching [route](https://github.com/lingtalfi/Light/blob/master/doc/pages/route.md) array.
- Light.on_exception_caught: when an exception is caught. The argument is a [Light_Event](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Events/LightEvent.md) object with an **exception** variable containing the caught exception.
        Plugins can set a response to return to the user by setting the **httpResponse** variable (in the LightEvent instance).
        The response must be an [HttpResponseInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpResponseInterface.md) instance.
- Light.on_unhandled_exception_caught: triggered when an exception is caught but not handled by a third party plugin. 
        This event can be used to log the unhandled exceptions for instance.

 
 
Events naming convention
--------------
 
For name consistency across the different light plugins, we recommend that plugin authors
use the following naming convention for naming events:

- eventName: {pluginName}.{event_name}

With:
- {pluginName}: the plugin name in [pascal case](https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.stringCases.eng.md#pascalcase) 
- {event_name}: the event name in [snake case](https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.stringCases.eng.md#snakecase) 