[Back to the Ling/Light api](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light.md)<br>
[Back to the Ling\Light\Core\Light class](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Core/Light.md)


Light::renderDebugPage
================



Light::renderDebugPage — Renders (returns the html code of) the debug page.




Description
================


protected [Light::renderDebugPage](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Core/Light/renderDebugPage.md)(Exception $e) : string | [HttpResponseInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpResponseInterface.md)




Renders (returns the html code of) the debug page.
You should override this method if you need a more sophisticated/fancy display.




Parameters
================


- e

    


Return values
================

Returns string | [HttpResponseInterface](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpResponseInterface.md).


Exceptions thrown
================

- [Exception](http://php.net/manual/en/class.exception.php).&nbsp;







Source Code
===========
See the source code for method [Light::renderDebugPage](https://github.com/lingtalfi/Light/blob/master/Core/Light.php#L557-L582)


See Also
================

The [Light](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Core/Light.md) class.

Previous method: [run](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Core/Light/run.md)<br>Next method: [renderInternalServerErrorPage](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Core/Light/renderInternalServerErrorPage.md)<br>

