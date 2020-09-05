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
