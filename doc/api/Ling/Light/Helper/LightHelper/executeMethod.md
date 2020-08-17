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
- argReplace: array=null, if set, will replace the arguments found in the given expr by some value. It's an array of argName => value.




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
See the source code for method [LightHelper::executeMethod](https://github.com/lingtalfi/Light/blob/master/Helper/LightHelper.php#L68-L128)


See Also
================

The [LightHelper](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/LightHelper.md) class.

Previous method: [createDummyRoutes](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Helper/LightHelper/createDummyRoutes.md)<br>

