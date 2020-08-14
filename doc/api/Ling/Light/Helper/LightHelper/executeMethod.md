[Back to the Ling/Light api](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light.md)<br>
[Back to the Ling\Light\Helper\LightHelper class](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/LightHelper.md)


LightHelper::executeMethod
================



LightHelper::executeMethod — Executes a php method based on the notation described below, and returns the result.




Description
================


public static [LightHelper::executeMethod](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/LightHelper/executeMethod.md)(string $expr, [Ling\Light\ServiceContainer\LightServiceContainerInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/ServiceContainer/LightServiceContainerInterface.md) $container, ?array $options = []) : mixed




Executes a php method based on the notation described below, and returns the result.


This technique originally comes from the [ClassTool::executePhpMethod](https://github.com/lingtalfi/Bat/blob/master/ClassTool.md#executephpmethod-aka-smart-php-method-call).

We've just added the possibility to call services by prefixing the service name with the @ symbol.


The given $expr must use the [light execute notation](https://github.com/lingtalfi/Light/blob/master/personal/mydoc/pages/notation/light-execute-notation.md).


See the [examples here](https://github.com/lingtalfi/Bat/blob/master/ClassTool.md#executephpmethod-aka-smart-php-method-call).



Available options are:
- onCallBefore: a callable to execute just before the actual method is executed.
     The callable has the following signature:
     - fn ( type, classOrService, method, args ): void

     With:
     - type: string, the type of call being executed, can be one of:
         - static, for static calls
         - instance, for calls on a new class instance
         - service, for service calls
     - classOrService: string, the name of the class or service being called
     - method: string, the name of the method being called
     - args: array, the array of arguments passed to the called method
- prependArgs: an array of arguments to prepend to the arguments list




Parameters
================


- expr

    

- container

    

- options

    


Return values
================

Returns mixed.


Exceptions thrown
================

- [Exception](http://php.net/manual/en/class.exception.php).&nbsp;







Source Code
===========
See the source code for method [LightHelper::executeMethod](https://github.com/lingtalfi/Light/blob/master/Helper/LightHelper.php#L85-L145)


See Also
================

The [LightHelper](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/LightHelper.md) class.

Previous method: [createDummyRoutes](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/LightHelper/createDummyRoutes.md)<br>

