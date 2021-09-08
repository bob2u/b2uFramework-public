# \B2U\Core\Response

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

A response is the combination of a set of headers and content sent back to a requester based on the request received.  This object helps encapsulate the response components and provides a built-in functionality to process varying response contents. Furthermore, the `\B2U\Core\Response` allows chaining of function calls to enable the construction of complex headers - as needed.

The `\B2U\Core\Response` is treated as a singleton within the framework, and a single instance is made available through the Action parameter `$this->Response()`, which is to build custom responses per Actions.

```PHP
$this->Response()->setHeader("Content-Type", "text/html")
               ->setContent("<h1>Welcome to B2uFramework</h1>");
```

# Methods
```PHP 
setHCode($key)
```
@param **$code** - `enum` - HTTP response code. One of:
```PHP
const ERROR             = 500;
const GET_OK            = 200;
const GET_NOT_FOUND     = 404;
const POST_OK           = 200;  // executed, nothing to return
const POST_OK_CREATE    = 201;	// record created
const POST_OK_EMPTY     = 204;	// empty body retrned
const POST_BAD_REQ      = 400;	// bad data provided
const PUT_OK_UPDATE     = 200;	// record updated
const PUT_OK_CREATE     = 201;	// record created
const PUT_OK_EMPTY      = 204;	// empty body returned
const PUT_CONFLICT      = 409;
const PATCH_OK          = 200;	// record partial updated
const PATCH_BAD_FROM    = 415;	// Unsupported Media Type
const PATCH_BAD_REQ     = 400;	
const PATCH_CONFLICT    = 409;
const DELETE_OK         = 204;
const DELETE_NOT_FOUND  = 404;
const ASYNC_ACCEPTED    = 202;	// send to client o indicate async process started
const ASYNC_COMPLETED   = 303;	// async operation completed
```
***@note -*** _If this function is not called then the default 200 will be provided, or 500 on system error_
##
```PHP 
setCode($http_code)
```
@param **$http_code** - `string` - HTTP response code to be sent with headers.

@return - `\B2U\Core\Response` - Returns the response object's instance for chaining

##
```PHP 
setHeader($key, $value)
```
@param **$key** - `string` - HTTP header flags.

@param **$value** - `string` - A value associated with the header parameter.

@return - `\B2U\Core\Response` - Returns the response object's instance for chaining

***@note -*** _If the `"Content-Type"` header is set as `"application/json"`, then the data provided must be encoded in JSON `string` format using `json_encode()`._
##
```PHP 
setContent($content)
```
@param **$content** - `string` - The content payload to be provided with the response. This can be a webpage's HTML, encoded file data, a JSON string, or any other valid `"Content-Type"` supported over HTTP.

***@note -*** _If the `"Content-Type"` header is set as `"application/json"`, then the $content data must be encoded in JSON `string` format using `json_encode()`. $content can be assigned as a raw `Array` only if `"Content-Type"` header is not set._

@return - `\B2U\Core\Response` - Returns the response object's instance for chaining
##
```PHP 
send($request_type)
```
@param **$request_type** - `string` - A value of `GET`. `POST`, `PUT`, `DELETE`, or `HEAD`.

This function will send headers back to a requester and terminate the PHP execution. It is typically called by the `\B2U\Core\Manager\` via `run()` or `respond()` functions, and would rarely be called by an application directly.

***@note -*** _When sending content back without a predefined `"Content-Type"` header, then this function will make every attempt to determine the type associated with the content. If it is unable to identify the content type, then it will throw an `\Exception`._
##
```PHP 
terminate($header)
```
@param **$header** - `string` - header information to be sent.

@return - `\B2U\Core\Response` - Returns the response object's instance for chaining

This is a unique response function that is used in cases where the application may want to send a different type of header information with no content (e.g. "HTTP/1.1 403 Forbidden" or "HTTP/1.1 404 File Not Found").

***@note -*** _Using this call will ignore the content being provided_
