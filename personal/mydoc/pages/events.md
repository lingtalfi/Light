Light events
=============
2019-11-06


Note: we use the [Light_Events](https://github.com/lingtalfi/Light_Events) service under the hood.


The Core/Light will dispatch the following events:


- Light.on_route_found: when a route matched. The argument is a [Light_Event](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Events/LightEvent.md) object which has a **route** variable containing the matching [route](https://github.com/lingtalfi/Light/blob/master/doc/pages/route.md) array.
- Light.on_exception_caught: when an exception is caught. The argument is a [Light_Event](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Events/LightEvent.md) object with an **exception** variable containing the caught exception.
        Plugins can set a response to return to the user by setting the **httpResponse** variable (in the LightEvent instance).
        The response must be an [HttpResponseInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpResponseInterface.md) instance.
        <br>We recommend that plugins that handle generic exceptions have a lower priority, and plugins that handle
        more specific exceptions have a higher priority by contrast.
        
- Light.on_unhandled_exception_caught: triggered when an exception is caught but not handled by a third party plugin. 
        This event can be used to log the unhandled exceptions for instance.
        
- Light.initialize_1: triggered at the beginning of the run method. The goal is to allow plugins to trigger their initialization routine (see the multi-level initialization section below for more details).
- Light.initialize_2: triggered at the beginning of the run method. The goal is to allow plugins to trigger their initialization routine (see the multi-level initialization section below for more details).
- Light.initialize_3: triggered at the beginning of the run method. The goal is to allow plugins to trigger their initialization routine (see the multi-level initialization section below for more details).

 
 
Events naming convention
--------------
 
For name consistency across the different light plugins, we recommend that plugin authors
use the following naming convention for naming events:

- eventName: {pluginName}.{event_name}

With:
- {pluginName}: the plugin name in [pascal case](https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.stringCases.eng.md#pascalcase) 
- {event_name}: the event name in [snake case](https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.stringCases.eng.md#snakecase) 



Multi-level initialization
-----------

One might wonder why do we have three different initialization events.
That's for handling dependencies between plugins.

Probably the best example of the problem is: imagine an admin plugin A that creates a database with an user table.

Now imagine another plugin B, which depends from plugin A and requires the user table to exist to do its things.

With our multi-level system, it's easily solved: plugin A would use the **Light.initialize_1** event to install
itself (and the user table), while plugin B would use the **Light.initialize_2** event, to be sure that plugin A's user table
is already installed.


So when you develop a plugin, just ask yourself this question: does my plugin depends from another one?
If yes, then you need to install it (if it has an install) on the level that comes AFTER the level on which 
the plugin it depends on is installed on.

And so sometimes you might have a plugin which depends on a plugin which depends on another plugin, hence
the level 3.

Should we need another level, we could simply add level 4, but that hasn't occurred yet (actually I didn't even
need level 3 so far either).



Note: at first I implemented it with a dependency system where plugins named the plugin they were dependent on,
but now I prefer this very flattened system, I believe it makes it clearer for everybody to understand what's going on
with the code. 

