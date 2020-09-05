# \B2U\Core\Session
b2uFramework provides basic session managment through the `\B2U\Core\Session` object, which encapsulates calls to PHP's session_* functions and the `$_SESSION` super global and uses the default PHP session handler - unless overridden.

***@note -*** _It is not recommened to use the default PHP session handler on shared hosting environments, and it is strongly recommended to use the  `Session::setHandlers()` feature to implement a custom database driven session handler_

In terms of security the `\B2U\Core\Session` object automatically provides the functionalities needed to protect against **Session Fixation**, **Session Hijacking**, and **Cross Site Request Forgery**. These features exists, but to some degree require the application developer's attention to ensure they cannot be circumvented.

#### CSRF Token
To utilize the CSRF Token feature on _forms_ and _AJAX_ calls a developer simply needs to call the special class member `csrftoken` on a `\B2U\Core\Session` object, which will:
1. Generate a unique CSRF token and store it in the current session, and 
2. Issue a cookie to the browser with the CSRF token value.

Applications can simply embed the token in their forms, or submit them via the request headers for AJAX calls. The framework provides methods for validating a token submitted.

To submit CSRF tokens with AJAX header request use the following code:
```javascript
$( document ).ajaxSend( function( event, jqXHR ) {
   jqXHR.setRequestHeader("X-CSRF-TOKEN", "{var:csrftoken}");
});
```

The `\B2U\Core\Session` is treated as a singletone, and there is only one instance of it for the duration of the script's execution. This instance is made available to all Plugins by default via `$this->Session` parameter, and can also be requested via `\B2U\Core\Manager::instance()->getSession()` or a direct call to `Session::instance()`. 

# Methods
```PHP 
Session::instance(array $config = [])
```
@param **$config** - `Array` - Default `empty Array`. This parameter can be used to set the `"Life"` and `"Kill"`/expiration time for the session object and cookie. Normally it is set by the [`\B2U\Core\Manager`](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoremanager)'s `setup()` method.

@return - `\B2U\Core\Session` - Returns the single instance of the session object which encapsulates the current `$_SESSION` super global, and provides functionalities for session management.
##
```PHP 
Session::setHandlers(array $callbacks)
```
@param **$callbacks** - `Array` - An array of callback functions that will set PHP session_* functionality for \[ _open_, _close_, _read_, _write_, _destroy_, _GC_, and optionally (_create_sid_, _validate_sid_, _update_timestamp_)]

This function can only be called prior to any calls to `\B2U\Core\Manager::instance()->run()`, or explicit calls to `getSession()` and `Session::instance()`, in order to override the default PHP session handler. If the goal is to tie the session handler to a special Interface that may also use a Database connection then calls to `Manager::instance()->getInterface("Database", ...)` can still safely be made at this point, as long as the rules are followed to ensure no calls to the session object are made prior to this function being called.
##
```PHP 
Session::instance()->getCsrfToken()
```
@return - `string` - Depending on the type of request (i.e. form, AJAX) the value for CSRF token can be retrieved via different channels. This function makes getting the token value simpler by consolidating calls to extract the token data. Order of operations for extracting are: 1. AJAX header, 2. GET/POST parameters, and 3. Cookie. This function returns `NULL` if token is not found.

***@note -*** _The token name used in GET/POST and cookies must be "csrftoken"._

***@note -*** _The header name used in AJAX requests must be "X-CSRF-TOKEN"._

##
```PHP 
Session::instance()->validate($csrf_token = false)
```
@param **$csrf_token** - `bool` - Default `false`. Calling this function will check the validity of the session, and if provided, the CSRF token. This function is an alias for `expire()` when called with `false` passed for the $csrf_token parameter. If CSRF token is a valid value, it will be checked against the current session token
##
```PHP 
Session::instance()->expired()
```
##
```PHP 
Session::instance()->regen()
```
##
```PHP 
Session::instance()->destroy()
```
