[Back to the Ling/Light api](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light.md)



The ControllerHelper class
================
2019-04-09 --> 2019-10-28






Introduction
============

The ControllerHelper class.



Class synopsis
==============


class <span class="pl-k">ControllerHelper</span>  {

- Methods
    - public static [resolveController](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/ControllerHelper/resolveController.md)($controller, [Ling\Light\Core\Light](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Core/Light.md) $light, array $route) : callable | null
    - public static [getControllerArgs](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/ControllerHelper/getControllerArgs.md)(callable $controller, array $route, [Ling\Light\Http\HttpRequestInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpRequestInterface.md) $httpRequest, [Ling\Light\Core\Light](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Core/Light.md) $light, [Ling\Light\ServiceContainer\LightServiceContainerInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/ServiceContainer/LightServiceContainerInterface.md) $container) : array
    - public static [getControllerArgsInfo](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/ControllerHelper/getControllerArgsInfo.md)(callable $controller) : array

}






Methods
==============

- [ControllerHelper::resolveController](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/ControllerHelper/resolveController.md) &ndash; controller can be extracted out of the given value.
- [ControllerHelper::getControllerArgs](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/ControllerHelper/getControllerArgs.md) &ndash; Returns the controller arguments for the given controller and matching route.
- [ControllerHelper::getControllerArgsInfo](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/ControllerHelper/getControllerArgsInfo.md) &ndash; Returns an array of controller args corresponding to the given controller.





Location
=============
Ling\Light\Helper\ControllerHelper<br>
See the source code of [Ling\Light\Helper\ControllerHelper](https://github.com/lingtalfi/Light/blob/master/Helper/ControllerHelper.php)



SeeAlso
==============
Previous class: [ConfigurationHelper](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/ConfigurationHelper.md)<br>Next class: [EnvironmentHelper](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/EnvironmentHelper.md)<br>
