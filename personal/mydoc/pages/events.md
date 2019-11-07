Light events
=============
2019-11-06


Note: we use the [Light_Events](https://github.com/lingtalfi/Light_Events) service under the hood.


The Core/Light will dispatch the following events:


- Light.on_route_found: when a route matched. The argument is a [Light_Event](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Events/LightEvent.md) object which has a route variable containing the matching [route](https://github.com/lingtalfi/Light/blob/master/doc/pages/route.md) array.

 
 
Events naming convention
--------------
 
For name consistency across the different light plugins, we recommend that plugin authors
use the following naming convention for naming events:

- eventName: {pluginName}.{event_name}

With:
- {pluginName}: the plugin name in [pascal case](https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.stringCases.eng.md#pascalcase) 
- {event_name}: the event name in [snake case](https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.stringCases.eng.md#snakecase) 