# b2uFramework
Lean PHP RESTful framework

b2uFramework is a minimalist's PHP framework to help developers get a site up and running quickly, while following some design & architecture rather than them echoing out PHP content sprinkled in an HTML file. Out of the box the framework supports a few core features to allow this minimalist approach to be achieved. Furthermore, b2uFramework supports an interface and plugin mechanism, which allows reusable system components and site content to be developed and used across projects.

The b2uFramework does what most PHP frameworks do for a typical process cycle:
1. Receive a request from a user
2. Parse the request to its components _i.e. API endpoint, methods, parameters_
3. Process the request via routing
4. Return a response to the request _i.e. JSON, file, HTML page, etc._

## Features Out-of-the-box
b2uFramework supports a set of feature that are ready to be used out-of-the-box:

* RESTFul API Architecture
* Session Management - Session Fixation, and Session Hijacking support
* OOP HTML Templates Utility
* Cross Site Request Forgery protection
* Abstract Plugin and Interface mechanism

## Terminology
There are a few basic concepts that have been established in order to help to understand the flow of data within this framework. These key concepts are:
* **Plugin (Directory) -** Plugins in b2uFramework are reusable website/application specific components. These components are organized under directories, and the given directory name corresponds to an API endpoint. A Plugin can contain one or many Actions.
* **Action (File/Class) -** An Action is a specific .php file where the file name corresponds to the API endpoint under the Plugin directory. The Action's .php file will contain a class with the same name as the Action file. An Action performs a set of specific tasks (i.e. Methods). 
* **Method (Function) -** A Method is a unique function within an Action class that will execute a task when requested. The _Default_ Method for all Actions is their `__construct(...)`

A typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method` Parameters can be passed vai `$_GET` by either calling: 

`www.sitename.com/plugin/action/method/var1/var2/var3...`

or 

`www.sitename.com/plugin/action/method?var1_name=var1=&var2_name=var2&var3_name=var3...`

Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class.

Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception.

* **Interface -** The primary use of an Interface is to maintain a single instance access to some resources that lives once through the execution of the entire script, which is one that will not require multiple instances. These are entrypoints into new/extended functionality that can be added to the framework, and used/re-used by the application's Plugins as well as other Interfaces. Each Interface can provide access to the any number of modules they support. Common pre-defined Interface categories are:

  * Server - containing modules for server technology
  * Authorization - common modules could be _HeaderAuthorization_, _LDAP_, _DatabaseDriven_, etc.
  * Database - most common for PHP would be _MySQL_ modules, and _OCI8_ modules
  * File - file management classes
  * Encryption - modules used for specific encryption technology
  * Payment - common payment gateway API modules/wrappers
  * Utility - general purpose modules _(e.g. Google MAPs API, Captue, AI, etc.)_

## Getting Started
The base framework consists of 2 php files, license file, and a web server configuration file. Simply place the ***index.php***, ***b2u.min.php*** file and the associated ***license.lic*** file in the root directory of a project. On Windows/IIS based servers use the ***web.config*** file, and for Linux/Apache based servers use the ***.htaccess*** file - placed in the root directory.

The entry point ***index.php*** has a `class index` defined, which will be the default Action/entry point into the application.

```PHP 
class index extends \B2U\Core\Action implements \B2U\Core\IAction {	
  ...
}
```
If the server configuration is setup correctly, accessing the root URL will run the site, and you should see a page with `Welcome to B2uFramework` displayed.

b2uFramework works by redirecting request to the site through ***index.php*** and from there routing it to the appropriate `Plugin / Action / Method` for processing.

## Understanding index.php
The ***index.php*** provided with the framework is required, and contains a basic setup for any given site. First, it defines a default `class index`, which is optional, and can be removed once the site's root directory is re-defined. Second, it contains (2) two calls to the `\B2U\Core\Manager` that initialize and run the site. ***index.php*** works as a default Action for the _root directory_ Plugin, with a default `__constuct(...)` Method.
```php
<?php
include("b2u.min.php");

class index extends \B2U\Core\Action implements \B2U\Core\IAction {	
  function __construct(& $params, & $response) {
    parent::__construct($params, $response);
    $this->Response->setHeader("Content-Type", "text/html")
                    ->setContent("<h1>Welcome to B2uFramework</h1>");
  }
}

try {
  \B2U\Core\Manager::instance()->setup([]);
  \B2U\Core\Manager::instance()->run();
}
catch(\Exception $e) {
  echo $e->getMessage();
}
?>
```

## The B2U\Core Namespace
The ***B2U\Core*** namespace contains all modules and classes need to run a site/application built on this framework. The main components are:

[\B2U\Core\Manager](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoremanager) - main framework entry point (singletone architecture)

[\B2U\Core\Session](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoresession) - session managment class

[\B2U\Core\Response](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoreresponse) - class for response construction

[\B2U\Core\Request](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucorerequest) - request pre-processor object

[\B2U\Core\HTMLTemplate](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucorehtmltemplate) - HTML templating interface

[\B2U\Core\Action](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoreaction) - class definition for API endpoints

[\B2U\Core\Module](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoremodule) - class definition for Interfaces (Database, Authorization, User, ...)

[\B2U\Core\Utility](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#b2ucoreutility) - static class with utility functions

# \B2U\Core\Manager
The ***Manager*** is a Singletone object, which means it will only have one instance of it allocated for the entire duration of the script execution, and that it provides interfaces to access most of the framework's objects via defined accessors.

## Methods
```PHP 
Manager::instance()
```
@return - `\B2U\Core\Manager` - Returns the single instance of the manager object when called from any .php script in the framework.
##
```PHP 
Manager::instance()->getSession()
```
@return - `\B2U\Core\Session` - Returns the single instance of the session object which encapsulates the current `$_SESSION` super global, and provides functionalities for session management.
##
```PHP 
Manager::instance()->getResponse()
```
@return - `\B2U\Core\Response` - Returns the response object to be populated by the application, which will be sent back to the requester.
##
```PHP 
Manager::instance()->getHeaders()
```
@return - `Array` - Returns a list of the headers associated with the ***Request*** to the server.
##
```PHP 
Manager::instance()->getParameters()
```
@return - `Array` - Returns a list, by value, of the ***Request*** parameters. These would include all `$_GET`, `$_POST`, and `$_FILE` entries, as well as any data received > through `php://input` pipeline.
##
```PHP 
Manager::instance()->getInterface($interface = "", $module = "", $new = false, ...$args)
```
@param **$interface** - `string` - The Interface category to search for a given loaded Module.

@param **$module** - `string` - The `namespace\class` Module to access.

@param **$new** - `bool` - Default `false`, optionally true can be provided that will generate a new instance and store it as the single Interface instance within b2uFramework that will be returned on future calls to this function using the same $interface and $module combination.

@param **$args** - `mixed` - A packed variable to allow multiple parameters to be passed to the constructor of the Module.

@return - `Object` - Returns an instance to the desired module or `false` on failure. Invalid parameters will result in a standard `\Exception`. Only providing the $interface will return an `Array` of all modules available in the given $interface category. If an empty $interface category is provided then the system will return an `Array` of all Interfaces and their Modules in the framework registry.

This function is used to get an instance to a specific Interface's Module. If the Module is not loaded this function will first attempt to load it, and allocate an instance of the Module within the Interface category. Generally there is only one (1) instance of a Module for the duration of a script's execution, but new instances can still be created, which will replace the old stored instance on future access. 

***@note -*** _A refernce to the old instance will need to be maintained by the application's developer if multiple instances of the same Interface Module are required at the same time._

In most applications Interfaces only need a single instance for the duration of the script's execution. But if multiple instances are needed then instead of using this function to create a single instance of a Module it should be used to point to a factory for the Module, which fits a single instance design pattern, and then the factory should be accessible to all scripts to create as many instances of a Module as needed.

An example of using an Interface would be for user authorization. The example below assumes the application has loaded a Module for LDAP processing.
```php
$ldap_auth = \B2U\Core\Manager::instance()->getInterface("Authorization", "My_LDAP", false, $ldap_config_params, "login_credentials");
if ($ldap_auth->isUserAuthorized()) {
  ...
}
```
##
```PHP 
Manager::instance()->setup($config)
```
@param **$config** - `Array` - Allow customization of the application by setting up the main routing and site configuration parameters.

The $config is an array that is used to provide data to setup the framework and the application, and it consists of the following sections:

1) **Includes** - An `Array of strings` for any global include files that should be loaded on each request, and any defintions that need to be made available to all Plugins and Interfaces.

2) **Plugins** - The actual site content will be in this section. It will primarily contain the root `"/"` Module (home page), and all other pages/modules. Each Plugin definition will have a required `"Path"` parameter set to a directory that contains the Plugin Action(s), and an optional `"Include"` parameter that can be set to an `Array of strings` for files to include that are used only within this Plugin. 

***@note -*** _Use the 1. **Includes** section for files that need to be used in more than one Plugin._

```php
"plugin_name" => [
   "Path" =>    // string
   "Include" => // Array of strings
]
```
***@note -*** _If the Plugin's Actions are in a `namespace` then the files containing the Action's deinition should include `return __NAMESPACE__;` as the last line of code within the file so that the framework would be able to determine the correct class objects that needs to be instantiated on any given Action call._

3) **Interfaces** - Third-party modules and reuseable APIs should be added to this section. @see [Terminology:Interfaces](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology) for more details. Modules are added under each Interface main category, following the format below. Each Module will have a required `"Path"` parameter that can either be the top-level directory to the Module, which will contain all .php files for its function that will be autoloaded, or the path to a specific file that contains the `module_name class` or an `_autoload` function.

```php
"interface_category" => [
   "namespace\model_name class" => [
      "Path" =>   // string
   ]
]
```

4) **Session** - (Optional) The session can be configured at startup to control its life span, and how/when to delete obsolete sessions. Values for all timing parameters are in seconds.

```php
[
   "Life" =>    // int - Default 1800
   "Kill" =>    // int - Default 300
]
```
##
```PHP 
Manager::instance()->augment($config, $mode)
```
@param **$config** - `Array` - Array of configuration parameters with respect the $mode.

@param **$mode** - `string` - Either `"Plugins"` or `"Interfaces"`.

In some instances as application will want to augment the existing Module definitions or Plugin definitions to include additional features. For example, the application would want to add a new parameter `"Role"` to the Plugin's definition beyond the standard `"Path"` and `"Include"` to be used during access permission checking operations. To accomplish this the `augment()` function can be called prior to or after `setup()`.
##
```PHP 
Manager::instance()->run()
```
Aliase for `parse()`, `route()`, and `response()` calls. `parse()` performs URL pasrsing and data extraction of the user's request into a `\B2U\Core\Request` object. `route()` does the heavy-lifting and routing of a request to the `Plugin / Action / Method` while passing all necessary parameters. `response()` is an aliase for the `B2U\Core\Response::send` function.
##
```PHP 
Manager::instance()->callEndpoint($endpoint, $request, $data, $session = true)
```
@param **$endpoint** - `string` - The target `Plugin/[Action/[Method]]` to be called

@param **$request** - `string` - One of the values of `GET`, `POST`, `PUT` or `DELETE`

@param **$data** - `Array` - Array of key/value pairs to be transmitted to the $endpoint using the defined $request

@param **$session** - `bool` - Default `true`, Indicates if Session cookie data should be sent to the target $endpoint.

@return - \[`Mixed`, `int`] - Returns the results of cURL call, and HTTP response code from making the request. Throws `\Exception` on any errors.


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

## Methods
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
##
