[Back to the Ling/Light api](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light.md)<br>
[Back to the Ling\Light\Http\HttpRequest class](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpRequest.md)


HttpRequest::getFilesValue
================



HttpRequest::getFilesValue — Returns the value corresponding to the given key in the $_FILES array attached with the request.




Description
================


public [HttpRequest::getFilesValue](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpRequest/getFilesValue.md)(string $key, ?bool $throwEx = false) : mixed




Returns the value corresponding to the given key in the $_FILES array attached with the request.
If such key was not found:

- if throwEx is true, an exception is thrown
- if throwEx is false, null is returned




Parameters
================


- key

    

- throwEx

    


Return values
================

Returns mixed.








Source Code
===========
See the source code for method [HttpRequest::getFilesValue](https://github.com/lingtalfi/Light/blob/master/Http/HttpRequest.php#L380-L389)


See Also
================

The [HttpRequest](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpRequest.md) class.

Previous method: [getFiles](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpRequest/getFiles.md)<br>Next method: [getCookie](https://github.com/lingtalfi/Light/blob/master/doc/api/Ling/Light/Http/HttpRequest/getCookie.md)<br>

