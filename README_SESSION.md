# \B2U\Core\Session
b2uFramework provides basic session management through the `\B2U\Core\Session` object, which encapsulates calls to PHP's session_* functions and the `$_SESSION` superglobal and uses the default PHP session handler - unless overridden.

***@note -*** _It is not recommended to use the default PHP session handler on shared hosting environments. It is strongly recommended to use the  `Session::setHandlers()` feature to implement a custom database-driven session handler._

In terms of security, the `\B2U\Core\Session` object automatically provides the functionalities needed to protect against **Session Fixation**, **Session Hijacking**, and **Cross Site Request Forgery**. Although these features exist, but to some degree, they require the application developer's attention to ensure they cannot be circumvented.

#### CSRF Token
To utilize the CSRF Token feature on _forms_ and _AJAX_ calls, a developer needs to call the special class member `csrftoken` on a `\B2U\Core\Session` object, which will:
1. Generate a unique CSRF token and store it in the current session, and 
2. Issue a cookie to the browser with the CSRF token value.

Applications can embed the token in their forms or submit them via the request headers for AJAX calls. The framework provides methods for validating a token submitted.

To submit CSRF tokens with AJAX header request, use the following code:
```javascript
$( document ).ajaxSend( function( event, jqXHR ) {
   jqXHR.setRequestHeader("X-CSRF-TOKEN", "{var:csrftoken}");
});
```

The `\B2U\Core\Session` is treated as a singleton, and there is only one instance of it for the duration of the script's execution. This instance is made available to all Plugins by default via `$this->Session` parameter, and can also be requested via `\B2U\Core\Manager::instance()->getSession()` or a direct call to `Session::instance()`. 

# Members
```PHP
csrftoken
```
Calling `$this->Session->csrftoken` within an Action, or `Session::instance()->csrftoken` from any script, will:

1. Issue new CSRF token that can be used in the following form or AJAX call.
2. Set the `"csrftoken"` cookie parameter to be sent back to the browser.

***@note -*** _Calling this member parameter immediately after a session's `validate()` call, which included a CSRF token check, will return the newly generated CSRF token without needing to issue a new token.  The new token can be used in the following form or AJAX call._
##
```PHP
life
```
Get and Set the current `"Life"` attribute programmatically for the duration of the current script's execution.
##
```PHP
dest
```
Get and Set the current `"Kill"` attribute programmatically for the duration of the current script's execution.
##
```PHP
{variable_name}
```
Get and Set a persistent custom parameter stored in the current `$_SESSION` superglobal, and can be accessed from the session object using the OOP `->variable_name` format.

***@note -*** _Setting a custom variable will start the session of it is not already in the `PHP_SESSION_ACTIVE` status._
# Methods
```PHP 
Session::instance(array $config = [])
```
@param **$config** - `Array` - Default `empty Array`. This parameter can be used to set the `"Life"` and `"Kill"`/expiration time for the session object and cookie. Normally it is set by the [`\B2U\Core\Manager`](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoremanager)'s `setup()` method.

@return - `\B2U\Core\Session` - Returns the session object's single instance, which encapsulates the current `$_SESSION` superglobal, and provides functionalities for session management.
##
```PHP 
Session::setHandlers(array $callbacks)
```
@param **$callbacks** - `Array` - An array of callback functions that will set PHP session_* functionality for \[ _open_, _close_, _read_, _write_, _destroy_, _GC_, and optionally (_create_sid_, _validate_sid_, _update_timestamp_)]

This function can only be called prior to any calls to `\B2U\Core\Manager::instance()->run()`, or explicit calls to `getSession()` and `Session::instance()`, in order to override the default PHP session handler. If the goal is to tie the session handler to an Interface, for example one that will use a Database connection, then any calls to `Manager::instance()->getInterface("Database", ...)` can still safely be made at this point, as long as no calls to the session object is made before this function is called.
##
```PHP 
Session::instance()->getCsrfToken()
```
@return - `string` - Depending on the type of request (i.e., form, AJAX), the CSRF token's value can be retrieved via different channels. This function makes getting the token value simpler by consolidating calls to extract the token data. The order of operations for extracting is 1. AJAX header, 2. GET/POST parameters, and 3. Cookie. This function returns `NULL` if the token is not found.

***@note -*** _The token name used in GET/POST and cookies must be "csrftoken"._

***@note -*** _The header name used in AJAX requests must be "X-CSRF-TOKEN"._

##
```PHP 
Session::instance()->validate($csrf_token = false)
```
@param **$csrf_token** - `bool` - Default `false`. Calling this function will check the validity of the session, and if provided, the CSRF token. This function is an alias for `expire()` when called with `false` passed for the $csrf_token parameter. If the CSRF token is a valid value, it will be checked against the current session token, and the resulting `true/false` status returned to the application.

If a CSRF token is validated, regardless of the validation results, the current session stored token will be invalidated, and a new CSRF token will be issued. The application can get this new token immediately by calling the special `csrftoken` parameter on the `\B2U\Core\Session\` object. This call **must** be the next call immediately following the `validate()` call to work.

@return - `bool` - Returns `true` or `false` depending on the status of the session object, and the validity of the CSRF token - if provided.
##
```PHP 
Session::instance()->expired()
```
@return - `bool` - Returns `true` or `false` depending on whether a session has expired due to inactivity. 

Every time a request to the script results in an initial `Session::instance()` call, an internal timer in the global `$_SESSION` will be updated to represent _time before last activity_. If the inactivity time is greater than the sessions's `"Life"` (Default 1800) then the session will be marked as expired.  It is the application's responsibility to take the appropriate action based on the results from this function.
##
```PHP 
Session::instance()->regen()
```
This function should get called generally once a significant event that elevates user privileges takes effect, such as user login. Before adding the elevated privileges parameter to the session object, the sessions id should be changed, and the previous session marked for destruction.
##
```PHP 
Session::instance()->destroy()
```
Destroys the current session active session and cookie values.
