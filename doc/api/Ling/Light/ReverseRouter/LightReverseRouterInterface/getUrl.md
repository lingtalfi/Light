[Back to the Ling/Light api](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light.md)<br>
[Back to the Ling\Light\ReverseRouter\LightReverseRouterInterface class](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/ReverseRouter/LightReverseRouterInterface.md)


LightReverseRouterInterface::getUrl
================



LightReverseRouterInterface::getUrl — Returns the url corresponding to the given route name and url parameters.




Description
================


abstract public [LightReverseRouterInterface::getUrl](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/ReverseRouter/LightReverseRouterInterface/getUrl.md)(string $routeName, array $urlParameters = [], bool $useAbsolute = false) : string




Returns the url corresponding to the given route name and url parameters.
If the useAbsolute flag is set to true, an absolute url will be returned.




Parameters
================


- routeName

    

- urlParameters

    

- useAbsolute

    


Return values
================

Returns string.


Exceptions thrown
================

- [LightException](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Exception/LightException.md).&nbsp;







See Also
================

The [LightReverseRouterInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/ReverseRouter/LightReverseRouterInterface.md) class.



